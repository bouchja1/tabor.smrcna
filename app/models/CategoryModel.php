<?php

//###INSERT-LICENSE-HERE###

namespace Models;

use Models\Interfaces\CategoryRepositoryInterface;

final class CategoryModel {

    /** @var CategoryRepositoryInterface */
    private $categoryStore;

    public function __construct(CategoryRepositoryInterface $categories) {
        $this->categoryStore = $categories;
    }

    public function findFilmCategoryById($id, $lang = 'cs') {
        return $this->categoryStore->findFilmCategoryById($id, $lang);
    }

    public function findAllFilmCategories($lang = 'cs') {
        return $this->categoryStore->findAllFilmCategories($lang);
    }

    public function findFilmCategoryByCategoryName($category, $lang = 'cs') {
        return $this->categoryStore->findFilmCategoryByCategoryName($category, $lang);
    }

}
