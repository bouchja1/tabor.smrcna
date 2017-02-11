<?php

//###INSERT-LICENSE-HERE###

namespace Models\Repositories\MySql;

use Models\Interfaces\CategoryRepositoryInterface;

final class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface {

    const TABLE_NAME = "categories";

    public function findFilmCategoryById($id, $lang) {
        return $this->filmCategoriesQuery($lang)
                        ->where("[id] = %i", $id)
                        ->fetch();
    }

    public function findAllFilmCategories($lang) {
        return $this->filmCategoriesQuery($lang)->fetchAll();
    }

    public function findFilmCategoryByCategoryName($category, $lang) {
        return $this->filmCategoriesQuery($lang)
                        ->where("[name_$lang]")
                        ->like("_utf8 %s COLLATE utf8_unicode_ci", $category)
                        ->fetch();
    }

    private function filmCategoriesQuery($lang) {
        return $this->connection
                        ->select("[id]")
                        ->select("[name_$lang]")->as("name")
                        ->select("[picture]")
                        ->from(self::TABLE_NAME);
    }

}
