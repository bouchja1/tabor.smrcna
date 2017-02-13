<?php

//###INSERT-LICENSE-HERE###

namespace Models;

use Models\Interfaces\LocationRepositoryInterface;

final class LocationModel
{

    /** @var LocationRepositoryInterface */
    private $locationStore;

    /** @var BaseModel */
    private $baseModel;

    /** @var LocationPhotoModel */
    private $locationPhotoModel;

    public function __construct(LocationRepositoryInterface $location, BaseModel $baseModel, LocationPhotoModel $locationPhotoModel)
    {
        $this->locationStore = $location;
        $this->baseModel = $baseModel;
        $this->locationPhotoModel = $locationPhotoModel;
    }

    public function beginTransaction()
    {
        return $this->baseModel->beginTransaction();
    }

    public function findLocation()
    {
        return $this->locationStore->findLocation();
    }

    public function commitTransaction()
    {
        return $this->baseModel->commitTransaction();
    }

    public function removeLocationPhotoById($id)
    {
        $this->locationPhotoModel->removePhotoById($id);
    }

    public function rollbackTransaction()
    {
        return $this->baseModel->rollbackTransaction();
    }

    public function updateLocation($values)
    {
        $this->locationStore->update($values);
    }

    public function saveLocation($values)
    {
        $this->locationStore->insert($values);
    }
}
