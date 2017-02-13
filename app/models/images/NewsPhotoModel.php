<?php

//###INSERT-LICENSE-HERE###

namespace Models;

use Models\Repositories\MySql\BaseRepository;

final class NewsPhotoModel extends BaseRepository {

    const TABLE_NAME = "news_photos";

    /**
     * Returns id if exists or false when not exists
     *
     * @param string $name
     * @return int
     */
    public function existsByName($name) {
        return $this->getDatabase()->select("id")->from(static::TABLE_NAME)->where("name = %s", $name)->fetch();
    }

    public function savePhoto($name, $newsId) {
        $arr = [
            'name' => $name,
            'news_id' => $newsId,
        ];
        $this->insert($arr);
    }
}
