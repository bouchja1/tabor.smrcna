<?php

//###INSERT-LICENSE-HERE###

namespace AdminModule\Components;

interface IEmailReceiversComponentFactory {

    /**
     * @return \AdminModule\Components\EmailReceiversComponent
     */
    public function create($emailReceiversModel);
}
