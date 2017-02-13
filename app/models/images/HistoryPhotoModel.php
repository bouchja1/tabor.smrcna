<?php

//###INSERT-LICENSE-HERE###

namespace Models;

use Models\Repositories\MySql\BaseRepository;

final class HistoryPhotoModel extends BaseRepository {

    const TABLE_NAME = "history_photos";

    public function findPhotosByTermId($id) {
        return $this->getDatabase()->select("*")->from(static::TABLE_NAME)->where("history_year_id = %i", $id)->fetchAll();
    }

    /**
     * Returns id if exists or false when not exists
     *
     * @param string $name
     * @return int
     */
    public function existsByName($name) {
        return $this->getDatabase()->select("id")->from(static::TABLE_NAME)->where("name = %s", $name)->fetch();
    }

    public function savePhoto($name, $historyId) {
        $arr = [
            'name' => $name,
            'history_year_id' => $historyId,
        ];
        $this->insert($arr);
    }
}
