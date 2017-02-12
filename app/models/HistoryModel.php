<?php

//###INSERT-LICENSE-HERE###

namespace Models;

use Models\Interfaces\HistoryRepositoryInterface;

final class HistoryModel {

    /** @var HistoryRepositoryInterface */
    private $historyStore;

    public function __construct(HistoryRepositoryInterface $terms) {
        $this->historyStore = $terms;
    }

    public function findAllTerms() {
        return $this->historyStore->findAllTerms();
    }
}
