<?php

//###INSERT-LICENSE-HERE###

namespace Models;

use Models\Repositories\MySql\BaseRepository;

final class EmailReceiversModel extends BaseRepository {

    const TABLE_NAME = "email_receivers";

    public function findAllReceivers() {
        return $this->findAll(self::TABLE_NAME);
    }

    public function removeReceiverById($id) {
        $res = $this->getDatabase()->query("DELETE FROM [" . static::TABLE_NAME . "] WHERE [id] = %i", $id);
        return $res;
    }

    public function saveReceiver($values) {
        $this->insert($values);
    }
}
