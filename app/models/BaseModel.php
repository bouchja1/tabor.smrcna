<?php

//###INSERT-LICENSE-HERE###

namespace Models;

use Models\Repositories\MySql\BaseRepository;

final class BaseModel extends BaseRepository {

    public function beginTransaction() {
        return $this->begin();
    }

    public function commitTransaction() {
        return $this->commit();
    }

    public function rollbackTransaction() {
        return $this->rollback();
    }
}
