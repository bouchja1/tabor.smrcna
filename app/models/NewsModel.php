<?php

//###INSERT-LICENSE-HERE###

namespace Models;

use Models\Interfaces\NewsRepositoryInterface;

final class NewsModel {

    /** @var NewsRepositoryInterface */
    private $newsStore;

    public function __construct(NewsRepositoryInterface $news) {
        $this->newsStore = $news;
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
        return $this->newsStore->insert($values);
    }
}
