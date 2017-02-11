<?php

//###INSERT-LICENSE-HERE###

namespace Models\Interfaces;

interface CategoryRepositoryInterface {

    public function findFilmCategoryById($id, $lang);

    public function findAllFilmCategories($lang);

    public function findFilmCategoryByCategoryName($category, $lang);
}
