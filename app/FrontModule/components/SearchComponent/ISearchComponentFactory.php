<?php

//###INSERT-LICENSE-HERE###

namespace FrontModule\Components;

interface ISearchComponentFactory {

    /**
     * @return \FrontModule\Components\SearchComponent
     */
    public function create($filmCategory);
}
