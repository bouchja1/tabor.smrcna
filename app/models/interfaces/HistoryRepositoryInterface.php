<?php

//###INSERT-LICENSE-HERE###

namespace Models\Interfaces;

interface HistoryRepositoryInterface {

    public function findAllTerms();

    public function deleteHistory($id);
}
