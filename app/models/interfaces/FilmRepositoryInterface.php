<?php

//###INSERT-LICENSE-HERE###

namespace Models\Interfaces;

interface FilmRepositoryInterface {

    public function findFilmById($id, $lang);

    public function findAllFilmsByCategoryCount($category);

    public function findAllFilmsByCategory($category, $limit, $lang);

    public function findAllFilmsByCategoryAndSearchText($category, $searchText, $lang);
}
