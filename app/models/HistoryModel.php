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

    public function updateHistory($values) {
        $this->historyStore->update($values);
    }

    public function findHistoryTermById($id) {
        return $this->historyStore->findHistoryById($id);
    }

    public function findAllTerms() {
        return $this->historyStore->findAllTerms();
    }

    public function saveHistory($values) {
        $this->historyStore->insert($values);
    }
}
