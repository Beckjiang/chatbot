<?php

/**
 * This file is part of CommuneChatbot.
 *
 * @link     https://github.com/thirdgerb/chatbot
 * @document https://github.com/thirdgerb/chatbot/blob/master/README.md
 * @contact  <thirdgerb@gmail.com>
 * @license  https://github.com/thirdgerb/chatbot/blob/master/LICENSE
 */

namespace Commune\Protocals\Intercom;

use Commune\Blueprint\Ghost\Cloner;
use Commune\Blueprint\Ghost\Context;


/**
 * @author thirdgerb <thirdgerb@gmail.com>
 */
interface RetainInput extends GhostInput
{
    public function toContext(Cloner $cloner) : Context;
}