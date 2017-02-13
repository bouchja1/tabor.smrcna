<?php

//###INSERT-LICENSE-HERE###

namespace Models;

use Models\Interfaces\NewsRepositoryInterface;

final class NewsModel {

    /** @var NewsRepositoryInterface */
    private $newsStore;

    /** @var BaseModel */
    private $baseModel;

    public function __construct(NewsRepositoryInterface $news, BaseModel $baseModel) {
        $this->newsStore = $news;
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

    public function updateNew($values) {
        $this->newsStore->update($values);
    }

    public function findNewsById($id) {
        return $this->newsStore->findNewsById($id);
    }

    public function findAllNews() {
        return $this->newsStore->findAllNews();
    }

    public function findPaginatedNews($paginator) {
        return $this->newsStore->findPaginatedNews($paginator);
    }

    public function saveNew($values) {
        $this->newsStore->insert($values);
        $newId = $this->newsStore->getDatabase()->insertId();
        return $newId;
    }
}
