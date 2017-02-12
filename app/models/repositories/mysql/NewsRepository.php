<?php

//###INSERT-LICENSE-HERE###

namespace Models\Repositories\MySql;

use Models\Interfaces\NewsRepositoryInterface;

final class NewsRepository extends BaseRepository implements NewsRepositoryInterface {

    const TABLE_NAME = "news";

    public function findNewsById($id) {
        return $this->findById($id);
    }

    public function findAllNews() {
        return $this->newsQuery()->fetchAll();
    }

    private function newsQuery() {
        return $this->connection
                        ->select("[id]")
                        ->select("[title]")
                        ->select("[datetime]")
                        ->select("[text]")
                        ->select("[image]")
                        ->from(self::TABLE_NAME)
                        ->orderBy('id', 'DESC');
    }

}