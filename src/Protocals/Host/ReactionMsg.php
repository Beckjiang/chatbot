<?php

/**
 * This file is part of CommuneChatbot.
 *
 * @link     https://github.com/thirdgerb/chatbot
 * @document https://github.com/thirdgerb/chatbot/blob/master/README.md
 * @contact  <thirdgerb@gmail.com>
 * @license  https://github.com/thirdgerb/chatbot/blob/master/LICENSE
 */

namespace Commune\Protocals\Host;

use Commune\Protocals\HostMsg;


/**
 * Ghost 对外发表的响应意图.
 * 通常会被 Renderer 解析成多个其它类型的 HostMsg
 *
 * @author thirdgerb <thirdgerb@gmail.com>
 */
interface ReactionMsg extends HostMsg
{

    const SYSTEM_PREFIX = 'commune.system.';
    const DIRECTIVE_PREFIX = 'commune.directive.';
    const VERBAL_PREFIX = 'commune.verbal.';




    public function getReactionId() : string;

    public function getParams() : array;
}