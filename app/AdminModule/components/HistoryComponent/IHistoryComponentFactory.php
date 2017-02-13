<?php

//###INSERT-LICENSE-HERE###

namespace FrontModule\Components;

interface IHistoryComponentFactory {

    /**
     * @return \FrontModule\Components\HistoryComponent
     */
    public function create($historyModel, $historyPhotoModel, $editedHistory);
}
