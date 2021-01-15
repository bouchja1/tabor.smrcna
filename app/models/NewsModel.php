<?php

//###INSERT-LICENSE-HERE###

namespace Models;

use Models\Interfaces\NewsRepositoryInterface;

final class NewsModel
{

    /** @var NewsRepositoryInterface */
    private $newsStore;

    /** @var BaseModel */
    private $baseModel;

    /** @var NewsPhotoModel */
    private $newsPhotoModel;

    public function __construct(NewsRepositoryInterface $news, BaseModel $baseModel, NewsPhotoModel $newsPhotoModel)
    {
        $this->newsStore = $news;
        $this->baseModel = $baseModel;
        $this->newsPhotoModel = $newsPhotoModel;
    }

    public function beginTransaction()
    {
        return $this->baseModel->beginTransaction();
    }

    public function commitTransaction()
    {
        return $this->baseModel->commitTransaction();
    }

    public function rollbackTransaction()
    {
        return $this->baseModel->rollbackTransaction();
    }

    public function removeNewById($id)
    {
        try {
            $this->newsPhotoModel->removePhotosByNewsId($id);
            $this->newsStore->deleteNew($id);
        } catch (\Exception $e) {
        }
    }

    public function removeNewPhotoById($id)
    {
        $this->newsPhotoModel->removePhotoById($id);
    }

    public function updateNew($values)
    {
        $this->newsStore->update($values);
    }

    public function findNewsById($id)
    {
        return $this->newsStore->findNewsById($id);
    }

    public function findAllNews()
    {
        return $this->newsStore->findAllNews();
    }

    public function findPaginatedNews($paginator)
    {
        return $this->newsStore->findPaginatedNews($paginator);
    }

    public function saveNew($values)
    {
        $this->newsStore->insert($values);
        $newId = $this->newsStore->getDatabase()->getInsertId();
        return $newId;
    }
}
