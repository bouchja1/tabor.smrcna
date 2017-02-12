<?php

//###INSERT-LICENSE-HERE###

namespace FrontModule\Components;

interface IWarningComponentFactory {

    /**
     * @return \FrontModule\Components\WarningComponent
     */
    public function create($warningsModel, $editedWarning);
}
