<?php

//###INSERT-LICENSE-HERE###

namespace FrontModule\Components;

interface INewComponentFactory {

    /**
     * @return \FrontModule\Components\NewComponent
     */
    public function create($newsModel, $newsPhotoModel, $editedNew);
}
