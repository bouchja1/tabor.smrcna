<?php

//###INSERT-LICENSE-HERE###

namespace Models\Repositories\MySql;

use Models\Interfaces\NewsRepositoryInterface;

final class NewsRepository extends BaseRepository implements NewsRepositoryInterface {

    const TABLE_NAME = "news";

    public function findNewsById($id) {
        return $this->newsQuery()
                        ->where("[id] = %i", $id)
                        ->fetch();
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
                        ->from(self::TABLE_NAME);
    }

}
