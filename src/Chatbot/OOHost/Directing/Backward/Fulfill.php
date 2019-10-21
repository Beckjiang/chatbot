<?php


namespace Commune\Chatbot\OOHost\Directing\Backward;


use Commune\Chatbot\OOHost\Context\Definition;
use Commune\Chatbot\OOHost\Directing\Navigator;

class Fulfill extends FallbackNavigator
{
    public function doDisplay(): ? Navigator
    {
        $context = $this->history->getCurrentContext();
        $caller = $context->getDef();
        $caller->callExiting(
            Definition::FULFILL,
            $context,
            $this->dialog
        );

        $intended = $this->history->intended();
        if (isset($intended)) {
            return $this->intendToCurrent($context);
        }

        return $this->then();
    }

}