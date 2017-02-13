<?php

namespace AdminModule;

use Nette;
use App\Model;


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

    /**
     * @var \FrontModule\Components\ILocationComponentFactory
     */
    private $locationComponentFactory;

    private $editedCamp;

    public function beforeRender() {
        parent::beforeRender();
        $this->editedCamp = $this->locationModel->findLocation();
    }

    public function actionDefault() {
        $camp = $this->locationModel->findLocation();
        $campAboutPhotos = $this->locationPhotoModel->findPhotosByLocationType("ABOUT");
        $campSurrPhotos = $this->locationPhotoModel->findPhotosByLocationType("SURROUNDINGS");
        $camp["photos_surroundings"] = $campSurrPhotos;
        $camp["photos_about"] = $campAboutPhotos;
        $this->template->camp = $camp;
    }

    public function actionRemovePhoto($id) {
        $this->locationPhotoModel->removePhotoById($id);
        $this->setView('default');
        $this->redirect("Location:default");
    }

    public function renderDefault()
    {

    }

    public function actionRemoveLocationPhoto($id) {
        $this->locationPhotoModel->removePhotoById($id);
        $this->setView('default');
    }

    public final function injectLocationModel(\Models\LocationModel $locationModel) {
        $this->locationModel = $locationModel;
    }

    public final function injectLocationPhotoModel(\Models\LocationPhotoModel $locationPhotoModel) {
        $this->locationPhotoModel = $locationPhotoModel;
    }

    public final function injectCreateLocationComponentFactory(\FrontModule\Components\ILocationComponentFactory $locationComponentFactory) {
        $this->locationComponentFactory = $locationComponentFactory;
    }

    /**
     * @return \FrontModule\Components\HistoryComponent
     */
    protected function createComponentNewLocationFormComponent() {
        return $this->locationComponentFactory->create($this->locationModel, $this->locationPhotoModel, $this->editedCamp);
    }
}
