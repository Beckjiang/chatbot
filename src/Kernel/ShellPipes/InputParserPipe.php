<?php

/**
 * This file is part of CommuneChatbot.
 *
 * @link     https://github.com/thirdgerb/chatbot
 * @document https://github.com/thirdgerb/chatbot/blob/master/README.md
 * @contact  <thirdgerb@gmail.com>
 * @license  https://github.com/thirdgerb/chatbot/blob/master/LICENSE
 */

namespace Commune\Kernel\ShellPipes;

use Commune\Blueprint\Kernel\Protocols\ShellInputRequest;
use Commune\Blueprint\Kernel\Protocols\ShellInputResponse;
use Commune\Blueprint\Kernel\Protocols\ShellOutputRequest;
use Commune\Blueprint\Kernel\Protocols\ShellOutputResponse;
use Commune\Blueprint\Shell\Parser\InputParser;


/**
 * @author thirdgerb <thirdgerb@gmail.com>
 */
class InputParserPipe extends AShellPipe
{
    protected function handleInput(
        ShellInputRequest $request,
        \Closure $next
    ): ShellInputResponse
    {
        $input = $request->getInput();
        $message = $input->getMessage();
        $handler = $this->session->shell->firstProtocolHandler(
            $this->session->container,
            $message,
            InputParser::class
        );

        if (isset($handler)) {
            $message = $handler($message);
            $input->setMessage($message);
        }

        return $next($request);
    }

    protected function handleOutput(
        ShellOutputRequest $request,
        \Closure $next
    ): ShellOutputResponse
    {
        return $next($request);
    }


}