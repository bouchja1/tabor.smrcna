<?php

//###INSERT-LICENSE-HERE###

namespace Models;

use Models\Interfaces\FilmRepositoryInterface;

final class FilmModel {

    /** @var FilmRepositoryInterface */
    private $filmStore;

    public function __construct(FilmRepositoryInterface $films) {
        $this->filmStore = $films;
    }

    public function findFilmById($id, $lang = 'cs') {
        return $this->filmStore->findFilmById($id, $lang);
    }
    
    public function findAllFilmsByCategoryCount($category) {
        return $this->filmStore->findAllFilmsByCategoryCount($category);
    }

    public function findAllFilmsByCategory($category, $limit, $lang = 'cs') {
        return $this->filmStore->findAllFilmsByCategory($category, $limit, $lang);
    }
    
    public function findAllFilmsByCategoryAndSearchText($category, $searchText, $lang = 'cs') {
        return $this->filmStore->findAllFilmsByCategoryAndSearchText($category, $searchText, $lang);
    }

}
