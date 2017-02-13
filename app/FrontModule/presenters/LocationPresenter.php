<?php

namespace FrontModule;

use Nette;
use App\Model;
use App\FrontModule\Presenters\ModuleBasePresenter;

class LocationPresenter extends ModuleBasePresenter
{

    /**
     * @var \Models\LocationModel
     */
    private $locationModel;

    /**
     * @var \Models\LocationPhotoModel
     */
    private $locationPhotoModel;

    public function actionDefault($pageNumber = 1)
    {
        $camp = $this->locationModel->findLocation();
        $campAboutPhotos = $this->locationPhotoModel->findPhotosByLocationType("ABOUT");
        $campSurrPhotos = $this->locationPhotoModel->findPhotosByLocationType("SURROUNDINGS");
        $camp["photos_surroundings"] = $campSurrPhotos;
        $camp["photos_about"] = $campAboutPhotos;
        $this->template->camp = $camp;
    }

    public function renderDefault()
    {

    }

    public final function injectLocationModel(\Models\LocationModel $locationModel)
    {
        $this->locationModel = $locationModel;
    }

    public final function injectLocationPhotoModel(\Models\LocationPhotoModel $locationPhotoModel)
    {
        $this->locationPhotoModel = $locationPhotoModel;
    }

}
