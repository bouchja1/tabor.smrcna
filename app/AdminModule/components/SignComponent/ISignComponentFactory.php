<?php

//###INSERT-LICENSE-HERE###

namespace AdminModule\Components;

interface ISignComponentFactory {

    /**
     * @return \AdminModule\Components\SignComponent
     */
    public function create();
}
