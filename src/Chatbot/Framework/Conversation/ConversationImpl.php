<?php

/**
 * Class Conversation
 * @package Commune\Chatbot\Framework\Converstaion
 */

namespace Commune\Chatbot\Framework\Conversation;

use Commune\Chatbot\Blueprint\Conversation\Ability;
use Commune\Chatbot\Blueprint\Conversation\Chat;
use Commune\Chatbot\Blueprint\Conversation\Conversation as Blueprint;
use Commune\Chatbot\Blueprint\Conversation\Conversation;
use Commune\Chatbot\Blueprint\Conversation\ConversationLogger;
use Commune\Chatbot\Blueprint\Conversation\ConversationMessage;
use Commune\Chatbot\Blueprint\Conversation\IncomingMessage;
use Commune\Chatbot\Blueprint\Conversation\Monologue;
use Commune\Chatbot\Blueprint\Conversation\MessageRequest;
//use Commune\Chatbot\Blueprint\Conversation\Signal;
use Commune\Chatbot\Blueprint\Conversation\User;
use Commune\Chatbot\Blueprint\Message\Message;
use Commune\Chatbot\Blueprint\Message\VerboseMsg;
use Commune\Chatbot\Config\ChatbotConfig;
use Commune\Chatbot\Contracts\EventDispatcher;
use Commune\Chatbot\Contracts\Translator;
use Commune\Chatbot\Framework\Exceptions\RuntimeException;
use Commune\Container\ContainerContract;
use Commune\Container\RecursiveContainer;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class Conversation
 * 用容器来实现会话. 缺点是不能序列化, 反序列化.
 *
 * 使用 静态变量容器, 绑定在静态变量中, 容器实例通用
 * 但单例 (singleton 与 share )仅为容器持有.
 * 这么做的目的是在同一个进程中隔离不同的请求.
 *
 * 当使用协程模式时, 就非常方便了, 可以通过容器实例获取各种请求级的实例
 * 然后在请求结束时自动销毁.
 *
 * 基于IoC 容器, 可以实现各种双向绑定.
 *
 */
class ConversationImpl implements Blueprint
{
    use RecursiveContainer, RunningSpyTrait;

    /**
     * @var string
     */
    protected $traceId;

    /**
     * @var string
     */
    protected $incomingMessageId;

    /**
     * @var Message[]
     */
    protected $replies = [];

    /**
     * @var OutgoingMessageImpl[]
     */
    protected $replyMessages = [];

    /**
     * @var bool
     */
    protected $asConversation = false;

    /**
     * @var \Closure[]
     */
    protected $finishCallers = [];

    public function onMessage(MessageRequest $request, ChatbotConfig $config): Blueprint
    {
        $container = new static($this->parentContainer);

        // 提高效率
        $container->share(ChatbotConfig::class, $config);

        // 绑定自身.
        $container->share(Conversation::class, $container);

        // share request
        $container->share( MessageRequest::class, $request);
        $container->share(get_class($request), $request);
        // 互相持有, 要注意内存泄露的问题.
        $request->withConversation($container);

        $container->asConversation = true;
        $trace = $container->getTraceId();

        static::addRunningTrace($trace, $container->getConversationId());
        return $container;
    }

    public function getReactorContainer(): ContainerContract
    {
        return $this->getParentContainer();
    }

    public function getEventDispatcher(): EventDispatcher
    {
        return $this->make(EventDispatcher::class);
    }

    public function fire(Event $event): void
    {
        $this->getEventDispatcher()->dispatch($event);
    }

    public function getLogger(): ConversationLogger
    {
        return $this->make(ConversationLogger::class);
    }

    /*------ status ------*/


    public function isInstanced() : bool
    {
        return $this->asConversation;
    }

    public function isAbleTo(string $abilityInterfaceName): bool
    {
        if (!is_a($abilityInterfaceName, Ability::class, TRUE)) {
            $this->getLogger()->warning(
                __METHOD__
                . ' is checking ability ' . $abilityInterfaceName
                . ' which is not sub class of ' . Ability::class
            );
            return false;
        }

        if (!$this->has($abilityInterfaceName)) {
            return false;
        }

        /**
         * @var Ability $ability
         */
        $ability = $this->make($abilityInterfaceName);
        return $ability->isAllowing($this);
    }

    /*------ id ------*/

    public function getTraceId(): string
    {
        return $this->traceId ?? $this->traceId = $this->getRequest()->fetchTraceId();
    }

    public function getConversationId(): string
    {
        return $this->getRequest()->fetchMessageId();
    }

    public function getIncomingMessage() : IncomingMessage
    {
        return $this->make(IncomingMessage::class);
    }

    public function getUser(): User
    {
        return $this->make(User::class);
    }

    public function getChat(): Chat
    {
        return $this->make(Chat::class);
    }


    /*------ components ------*/

    public function getRequest(): MessageRequest
    {
        return $this->shared[MessageRequest::class];
    }

    /**
     * @var string
     */
    protected $locale;

    protected function locale() : string
    {
        return $this->locale
            ?? $this->locale = $this->getChatbotConfig()
                    ->translation
                    ->defaultLocale;
    }

    public function reply(Message $message, bool $immediately = false): void
    {
        if ($message instanceof VerboseMsg) {
            $message->translate(
                $this->make(Translator::class),
                $this->locale()
            );
        }

        $request = $this->getRequest();
        $incomingMessage = $this->getIncomingMessage();

        $replyMessage =  new OutgoingMessageImpl(
            $incomingMessage,
            $request->generateMessageId(),
            $message
        );

        $this->saveConversationMessage($request, $replyMessage, $immediately);
    }

    public function deliver(string $userId, Message $message, bool $immediately = false): void
    {
        if ($message instanceof VerboseMsg) {
            $message->translate(
                $this->make(Translator::class),
                $this->locale()
            );
        }

        $request = $this->getRequest();
        $chat = new ChatImpl(
            $request->getPlatformId(),
            $userId,
            $request->getChatbotUserId()
        );

        $toChat = new ToChatMessage(
            $chat,
            $request->generateMessageId(),
            $message,
            $this->getTraceId()
        );

        $this->saveConversationMessage($request, $toChat,  $immediately);
    }


    public function monolog(): Monologue
    {
        return $this->make(Monologue::class);
    }


    public function saveConversationMessage(
        MessageRequest $request,
        ConversationMessage $message,
        bool  $immediatelyBuffer
    ) : void
    {
        if ($immediatelyBuffer) {
            // 先缓冲起消息来. 是不是立刻发送, request 自己决定.
            $request->bufferConversationMessage($message);
        } else {
            // 这个和buffer 不一样, 用于别的处理, 比如存储消息.
            $this->replyMessages[] = $message;
        }
    }

    public function flushConversationMessages(): void
    {
        $this->replyMessages = [];
    }

    /*------ input ------*/

    public function getChatbotConfig(): ChatbotConfig
    {
        return $this->make(ChatbotConfig::class);
    }

    /*---------- signal -----------*/
//
//    /**
//     * @deprecated
//     * @param Signal $signal
//     */
//    public function sendSignal(Signal $signal): void
//    {
//        $signal->withConversation($this);
//        $this->getEventDispatcher()->listenCallable(
//            ChatbotPipeStart::class,
//            [$signal, 'handle']
//        );
//
//        $this->getEventDispatcher()->listenCallable(
//            ChatbotPipeClose::class,
//            [$signal, 'handle']
//        );
//    }




    /*---------- 收尾记录 -----------*/


    public function onFinish(callable $caller, bool $atEndOfTheQueue = true): void
    {
        if ($atEndOfTheQueue) {
            $this->finishCallers[] = $caller;
        } else {
            array_unshift($this->finishCallers, $caller);
        }
    }

    public function finishRequest(): void
    {
        try {

            // 发送消息.
            $request = $this->getRequest();

            foreach ($this->replyMessages as $message) {
                $request->bufferConversationMessage($message);
            }

            $this->replyMessages = [];

            // 发送所有消息.
            $request->flushChatMessages();
            // 这一步.
            $request->finishRequest();

        } catch (\Exception $e) {
            throw new RuntimeException($e);
        }
    }

    public function finish() : void
    {
        try {
            foreach ($this->finishCallers as $caller) {
                $this->call($caller, [Conversation::class => $this]);
            }

            $this->unsetSelf();

        } catch (\Exception $e) {
            $this->unsetSelf();
            throw new RuntimeException($e);
        }
    }

    protected function unsetSelf()
    {
        $this->finishCallers = null;
        $this->replies = null;
        $this->replyMessages = null;
        $this->incomingMessageId = null;
        $this->asConversation = false;
        $this->flushInstance();
    }

    public function __destruct()
    {
        static::removeRunningTrace($this->traceId);
    }
}