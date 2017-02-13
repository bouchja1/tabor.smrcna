<?php

//###INSERT-LICENSE-HERE###

namespace Models\Repositories\MySql;

use Models\Interfaces\LocationRepositoryInterface;

final class LocationRepository extends BaseRepository implements LocationRepositoryInterface {

    const TABLE_NAME = "location";

    public function findLocation() {
        $allLoc = $this->findAll(self::TABLE_NAME);
        if (sizeof($allLoc) > 0) {
            return $allLoc[0];
        } else {
            return null;
        }
    }

}
