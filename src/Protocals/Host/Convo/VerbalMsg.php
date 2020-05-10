<?php

/**
 * This file is part of CommuneChatbot.
 *
 * @link     https://github.com/thirdgerb/chatbot
 * @document https://github.com/thirdgerb/chatbot/blob/master/README.md
 * @contact  <thirdgerb@gmail.com>
 * @license  https://github.com/thirdgerb/chatbot/blob/master/LICENSE
 */

namespace Commune\Protocals\Host\Convo;

use Commune\Protocals\Host\ConvoMsg;

/**
 * 文字类型的消息.
 *
 * @author thirdgerb <thirdgerb@gmail.com>
 */
interface VerbalMsg extends ConvoMsg
{
    public function getText() : string;
}