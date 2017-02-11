<?php

//###INSERT-LICENSE-HERE###

namespace Models\Repositories\MySql;

use Models\Interfaces\FilmRepositoryInterface;

final class FilmRepository extends BaseRepository implements FilmRepositoryInterface {

    const TABLE_NAME = "films";
    const TABLE_JOIN_NAME = "film_categories";

    public function findFilmById($id, $lang) {
        return $this->filmsQuery($lang)
                        ->select("[" . self::TABLE_JOIN_NAME . "].[category_id]")->as("[category_id]")
                        ->join(self::TABLE_JOIN_NAME)
                        ->on("[" . self::TABLE_NAME . "].[id] = [" . self::TABLE_JOIN_NAME . "].[film_id]")
                        ->where("[id] = %i", $id)
                        ->fetch();
    }

    public function findAllFilmsByCategoryCount($categoryId) {
        return $this->connection
                        ->select("count(*)")
                        ->as("count")
                        ->from(self::TABLE_NAME)
                        ->join(self::TABLE_JOIN_NAME)
                        ->on("[" . self::TABLE_NAME . "].[id] = [" . self::TABLE_JOIN_NAME . "].[film_id]")
                        ->where("[category_id] = %i", $categoryId)
                        ->fetch();
    }

    public function findAllFilmsByCategory($categoryId, $limit, $lang) {
        return $this->filmsQuery($lang)
                        ->join(self::TABLE_JOIN_NAME)
                        ->on("[" . self::TABLE_NAME . "].[id] = [" . self::TABLE_JOIN_NAME . "].[film_id]")
                        ->where("[category_id] = %i", $categoryId)
                        ->limit($limit)
                        ->orderBy("[name]")
                        ->fetchAll();
    }

    public function findAllFilmsByCategoryAndSearchText($categoryId, $searchText, $lang) {
        return $this->filmsQuery($lang)
                        ->join(self::TABLE_JOIN_NAME)
                        ->on("[" . self::TABLE_NAME . "].[id] = [" . self::TABLE_JOIN_NAME . "].[film_id]")
                        ->where("[category_id] = %i", $categoryId)
                        ->and("[name_$lang]")
                        ->like("%s", "%$searchText%")
                        ->fetchAll();
    }

    private function filmsQuery($lang) {
        return $this->connection
                        ->select("[id]")
                        ->select("[name_$lang]")->as("name")
                        ->select("[description_$lang]")->as("description")
                        ->select("[picture]")
                        ->select("[length]")
                        ->select("[country_$lang]")->as("country")
                        ->select("[link]")
                        ->from(self::TABLE_NAME);
    }

}
