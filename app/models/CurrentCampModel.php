<?php

//###INSERT-LICENSE-HERE###

namespace Models;

use Models\Repositories\MySql\BaseRepository;

final class CurrentCampModel extends BaseRepository {

    const TABLE_NAME = "current_year_info";

    public function findAllCamps() {
        return $this->findAll(self::TABLE_NAME);
    }

    public function findActiveCamp() {
        return $this->getDatabase()->query("SELECT * FROM [" . self::TABLE_NAME . "] WHERE [active] = %i", 1)->fetch();
    }

    public function existsPictureByName($name) {
        return $this->getDatabase()->select("id")->from(self::TABLE_NAME)->where("poster = %s", $name)->fetch();
    }

    public function beginTransaction() {
        return $this->begin();
    }

    public function removeCurrentYearById($id) {
        return $this->delete($id);
    }

    public function commitTransaction() {
        return $this->commit();
    }

    public function rollbackTransaction() {
        return $this->rollback();
    }

    public function findCurrentYearById($id) {
        return $this->findById($id);
    }

    public function activateCurrentYearById($id) {
        $this->beginTransaction();
        try {
            // deactivate all camps LIKE query
            $active = [
                'active' => 0
            ];
            $this->getDatabase()->query("UPDATE [" . self::TABLE_NAME . "] SET ", (array)$active);
            // activate selected camp
            $active['active'] = 1;
            $this->getDatabase()->query("UPDATE [" . self::TABLE_NAME . "] SET ", (array)$active, " WHERE [id] = %i", $id);
        } catch (\DibiDriverException $ex) {
            $this->rollbackTransaction();
            throw $ex;
        }
        $this->commitTransaction();
    }

    public function updateCurrentYearInfo($values) {
        $this->update($values);
    }

    public function saveCurrentYearInfo($values, $name) {
        $values["poster"] = $name;
        $this->insert($values);
    }
}
