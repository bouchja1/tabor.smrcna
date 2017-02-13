<?php

//###INSERT-LICENSE-HERE###

namespace Models;

use Models\Repositories\MySql\BaseRepository;

final class LocationPhotoModel extends BaseRepository {

    const TABLE_NAME = "location_photos";

    public function findPhotosByLocationType($type) {
        return $this->getDatabase()->select("*")->from(static::TABLE_NAME)->where("location_type = %s", $type)->fetchAll();
    }

    public function removePhotoById($id) {
        $res = $this->getDatabase()->query("DELETE FROM [" . static::TABLE_NAME . "] WHERE [id] = %i", $id);
        return $res;
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

    public function savePhoto($name, $locationType) {
        $arr = [
            'name' => $name,
            'location_type' => $locationType,
        ];
        $this->insert($arr);
    }
}
