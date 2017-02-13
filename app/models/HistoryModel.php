<?php

//###INSERT-LICENSE-HERE###

namespace Models;

use Models\Interfaces\HistoryRepositoryInterface;

final class HistoryModel {

    /** @var HistoryRepositoryInterface */
    private $historyStore;

    /** @var BaseModel */
    private $baseModel;

    public function __construct(HistoryRepositoryInterface $terms, BaseModel $baseModel) {
        $this->historyStore = $terms;
        $this->baseModel = $baseModel;
    }

    public function beginTransaction() {
        return $this->baseModel->beginTransaction();
    }

    public function commitTransaction() {
        return $this->baseModel->commitTransaction();
    }

    public function rollbackTransaction() {
        return $this->baseModel->rollbackTransaction();
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
        $historyId = $this->historyStore->getDatabase()->insertId();
        return $historyId;
    }
}
