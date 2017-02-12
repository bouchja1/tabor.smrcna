<?php

//###INSERT-LICENSE-HERE###

namespace Models\Interfaces;

interface NewsRepositoryInterface {

    public function findNewsById($id);

    public function findAllNews();

    public function findPaginatedNews($paginator);
}
