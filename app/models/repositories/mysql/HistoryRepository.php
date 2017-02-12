<?php

//###INSERT-LICENSE-HERE###

namespace Models\Repositories\MySql;

use Models\Interfaces\HistoryRepositoryInterface;

final class HistoryRepository extends BaseRepository implements HistoryRepositoryInterface {

    const TABLE_NAME = "history";

    public function findHistoryById($id)
    {
        return $this->findById($id);
    }

    public function findAllTerms() {
        return $this->historyQuery()->fetchAll();
    }

    private function historyQuery() {
        return $this->connection
                        ->select("[id]")
                        ->select("[year]")
                        ->select("[title]")
                        ->select("[text]")
                        ->from(self::TABLE_NAME)
                        ->orderBy('year', 'DESC');
    }

}
