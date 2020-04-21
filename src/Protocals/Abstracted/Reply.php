<?php

/**
 * This file is part of CommuneChatbot.
 *
 * @link     https://github.com/thirdgerb/chatbot
 * @document https://github.com/thirdgerb/chatbot/blob/master/README.md
 * @contact  <thirdgerb@gmail.com>
 * @license  https://github.com/thirdgerb/chatbot/blob/master/LICENSE
 */

namespace Commune\Protocals\Abstracted;

use Commune\Protocals\Abstracted;
use Commune\Protocals\MessageProto;


/**
 * @author thirdgerb <thirdgerb@gmail.com>
 *
 *
 * @property-read MessageProto[]|null $replies      建议的回复.
 */
interface Reply extends Abstracted
{
}