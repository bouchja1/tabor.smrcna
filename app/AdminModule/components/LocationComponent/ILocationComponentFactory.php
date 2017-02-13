<?php

//###INSERT-LICENSE-HERE###

namespace FrontModule\Components;

interface ILocationComponentFactory {

    /**
     * @return \FrontModule\Components\LocationComponent
     */
    public function create($locationModel, $locationPhotoModel, $editedCamp);
}
