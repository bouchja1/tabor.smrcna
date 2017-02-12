<?php

//###INSERT-LICENSE-HERE###

namespace FrontModule\Components;

interface ICurrentCampComponentFactory {

    /**
     * @return \FrontModule\Components\CurrentCampComponent
     */
    public function create($currentCampModel, $editedCurrentCamp);
}
