<?php

/**
 * Class Conversation
 * @package Commune\Chatbot\Blueprint\Conversation
 */

namespace Commune\Chatbot\Blueprint\Conversation;

use Commune\Chatbot\Blueprint\Message\Message;
use Symfony\Component\EventDispatcher\Event;

/**
 * 使用IoC容器来承载一个请求, 将请求内的依赖都包装到这个容器内.
 * 好处是让一个请求内不同的模块, 可以通过依赖注入的方式分享各种组件.
 */
interface Conversation extends ConversationContainer, RunningSpy
{

    /*------------ create ------------*/

    /**
     * @return bool
     */
    public function isInstanced() : bool;

    /*------------ policy ------------*/

    /**
     * 检查当前conversation 是否拥有某种权限.
     * 需要传入一个class name
     *
     * 条件1: 参数是 class, 而且是 Ability 的子类.
     * 条件2: Ability 可以被容器实例化.
     * 条件3: 运行 isAllowing($conversation) 通过.
     *
     * @param string $abilityInterfaceName
     * @return bool
     */
    public function isAbleTo(string $abilityInterfaceName) : bool;

    /*------------ conversational ------------*/

    /**
     * conversation 的 trace id, 用于记录各种数据.
     * @return string
     */
    public function getTraceId() : string;

    /**
     * 所有的conversation 都要有独立的id
     * @return string
     */
    public function getConversationId() : string;

    public function getIncomingMessage() : IncomingMessage;

    /**
     * 获取用户
     * @return User
     */
    public function getUser() : User;

    public function getChat() : Chat;

    /*------------ components ------------*/

    /**
     * 获取日志模块
     * @return ConversationLogger
     */
    public function getLogger() : ConversationLogger;

    /**
     * 当前请求的处理器
     * @return MessageRequest
     */
    public function getRequest() : MessageRequest;

    /**
     * 和用户对话的模块.
     * @return Monologue
     */
    public function monolog() : Monologue;

    /**
     * 回复消息给当前用户
     * @param Message $message
     * @param bool $immediately
     */
    public function reply(Message $message, bool $immediately = false) : void;

    /**
     * 转发消息不是给当前用户, 而是给制定的用户.
     *
     * @param string $userId
     * @param Message $message
     * @param bool $immediately
     */
    public function deliver(string $userId, Message $message, bool $immediately = false) : void;

    /*------------ conversation messages ------------*/

    /**
     * 保存要发送的消息.
     * @param MessageRequest $request
     * @param ConversationMessage $message
     * @param bool $immediatelyBuffer  是否立刻交给 request 去 buffer, 如果这么做就反悔不了了.
     */
    public function saveConversationMessage(
        MessageRequest $request,
        ConversationMessage $message,
        bool  $immediatelyBuffer
    ) : void;

    /**
     * 清空所有要发送的消息
     */
    public function flushConversationMessages() : void;


    /**
     * 完成一个请求, 把所有消息发送出去.
     */
    public function finishRequest() : void;

    /*------------ event ------------*/

    /**
     * 触发事件.
     * @param Event $event
     */
    public function fire(Event $event) : void;

    /*------------ input & output ------------*/

    /**
     * 结束一个 conversation
     * 为 destruct 做准备.
     */
    public function finish() : void;

    /**
     * 在结束的时候触发的逻辑.
     * @param callable $caller
     * @param bool $atEndOfTheQueue
     */
    public function onFinish(callable $caller, bool $atEndOfTheQueue = true) : void;



}