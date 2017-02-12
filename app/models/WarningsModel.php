<?php

//###INSERT-LICENSE-HERE###

namespace Models;

use Models\Repositories\MySql\BaseRepository;

final class WarningsModel extends BaseRepository {

    const TABLE_NAME = "warnings";

    public function findWarningById($id) {
        return $this->findById($id);
    }

    public function updateWarning($values) {
        $this->update($values);
    }

    public function findAllWarnings() {
        return $this->findAll(self::TABLE_NAME);
    }

    public function saveWarning($values) {
        $this->insert($values);
    }
}
