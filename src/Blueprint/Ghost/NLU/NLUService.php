<?php

/**
 * This file is part of CommuneChatbot.
 *
 * @link     https://github.com/thirdgerb/chatbot
 * @document https://github.com/thirdgerb/chatbot/blob/master/README.md
 * @contact  <thirdgerb@gmail.com>
 * @license  https://github.com/thirdgerb/chatbot/blob/master/LICENSE
 */

namespace Commune\Blueprint\Ghost\NLU;

use Commune\Framework\Blueprint\Comprehension;

/**
 * @author thirdgerb <thirdgerb@gmail.com>
 */
interface NLUService
{

    public function shouldComprehend(string $text) : bool;

    public function comprehend(Comprehension $comprehension, string $text) : Comprehension;
}