<?php

/**
 * This file is part of CommuneChatbot.
 *
 * @link     https://github.com/thirdgerb/chatbot
 * @document https://github.com/thirdgerb/chatbot/blob/master/README.md
 * @contact  <thirdgerb@gmail.com>
 * @license  https://github.com/thirdgerb/chatbot/blob/master/LICENSE
 */

namespace Commune\Blueprint\Ghost\Definition;

use Commune\Blueprint\Ghost\Cloner;
use Commune\Blueprint\Ghost\Dialog;
use Commune\Blueprint\Ghost\Dialogue\Escaper;
use Commune\Blueprint\Ghost\Dialogue\Retain;
use Commune\Blueprint\Ghost\Routes\Activate;
use Commune\Blueprint\Ghost\Routes\Intercept;
use Commune\Blueprint\Ghost\Routes\React;
use Commune\Blueprint\Ghost\Routes\Retrace;
use Commune\Blueprint\Ghost\Operator\Operator;

/**
 * Stage 的封装对象
 *
 * @author thirdgerb <thirdgerb@gmail.com>
 */
interface StageDef
{

    /*------- properties -------*/

    /**
     * Stage 在 Context 内部的唯一ID
     * @return string
     */
    public function getName() : string;

    /**
     * stage 的全名, 通常对应 IntentName
     * @return string
     */
    public function getFullname() : string;

    /**
     * 所属 Context 的名称.
     * @return string
     */
    public function getContextName() : string;

    /**
     * @return IntentDef
     */
    public function asIntentDef() : IntentDef;

    public function comprehendPipes(Cloner $cloner) : ? array;

    /*------- intend to stage -------*/

    public function onRedirect(Dialog $from, Dialog $to) : Dialog;

    public function onActivate(Activate $activate) : Dialog;

    public function onRetain(Retain $retain) : Dialog;

    public function onEscape(Escaper $escaper) : Dialog;

}