<?php

//###INSERT-LICENSE-HERE###

namespace Models;

use Models\Repositories\MySql\BaseRepository;

final class CurrentCampModel extends BaseRepository {

    const TABLE_NAME = "current_year_info";

    public function findAllCamps() {
        return $this->findAll(self::TABLE_NAME);
    }

    public function findCurrentYearById($id) {
        return $this->findById($id);
    }

    public function updateCurrentYearInfo($values) {
        $this->update($values);
    }

    public function saveCurrentYearInfo($values) {
        $this->insert($values);
    }
}
