<?php

//###INSERT-LICENSE-HERE###

namespace FrontModule\Components;

interface IContactFormComponentFactory {

    /**
     * @return \FrontModule\Components\ContactFormComponent
     */
    public function create($mailsModel);
}
