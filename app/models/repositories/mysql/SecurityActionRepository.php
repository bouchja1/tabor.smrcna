<?php

//###INSERT-LICENSE-HERE###

namespace Models\Repositories\MySql;

use Models\Interfaces\HistoryRepositoryInterface;
use Models\Interfaces\SecurityActionRepositoryInterface;

final class SecurityActionRepository extends BaseRepository implements SecurityActionRepositoryInterface {

    const TABLE_NAME = "securityAction";

    public function findAllActions() {
        return $this->securityActionsQuery()->fetchAll();
    }

    public function findPermissionByUser($userId) {
        return $this->connection
            ->select("[id]")
            ->select("[action]")
            ->from(self::TABLE_NAME)
            ->where("[id] = %i", $userId)
            ->fetchAll();
    }

    public function findUserByUsername($username) {
        return $this->connection
            ->select("[id]")
            ->select("[username]")
            ->select("[password]")
            ->select("[action]")
            ->from(self::TABLE_NAME)
            ->where("[username] = %s", $username)
            ->fetch();
    }

    private function securityActionsQuery() {
        return $this->connection
                        ->select("[id]")
                        ->from(self::TABLE_NAME);
    }

}
