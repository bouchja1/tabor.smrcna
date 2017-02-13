<?php

//###INSERT-LICENSE-HERE###

namespace Models;

use Models\Interfaces\HistoryRepositoryInterface;

final class HistoryModel
{

    /** @var HistoryRepositoryInterface */
    private $historyStore;

    /** @var BaseModel */
    private $baseModel;

    /** @var HistoryPhotoModel */
    private $historyPhotoModel;

    public function __construct(HistoryRepositoryInterface $terms, BaseModel $baseModel, HistoryPhotoModel $historyPhotoModel)
    {
        $this->historyStore = $terms;
        $this->baseModel = $baseModel;
        $this->historyPhotoModel = $historyPhotoModel;
    }

    public function beginTransaction()
    {
        return $this->baseModel->beginTransaction();
    }

    public function commitTransaction()
    {
        return $this->baseModel->commitTransaction();
    }

    public function removeHistoryById($id)
    {
        try {
            $this->historyPhotoModel->removePhotosByHistoryId($id);
            $this->historyStore->deleteHistory($id);
        } catch (\Exception $e) {
        }
    }

    public function removeHistoryPhotoById($id)
    {
        $this->historyPhotoModel->removePhotoById($id);
    }

    public function rollbackTransaction()
    {
        return $this->baseModel->rollbackTransaction();
    }

    public function updateHistory($values)
    {
        $this->historyStore->update($values);
    }

    public function findHistoryTermById($id)
    {
        return $this->historyStore->findHistoryById($id);
    }

    public function findAllTerms()
    {
        return $this->historyStore->findAllTerms();
    }

    public function saveHistory($values)
    {
        $this->historyStore->insert($values);
        $historyId = $this->historyStore->getDatabase()->insertId();
        return $historyId;
    }
}
