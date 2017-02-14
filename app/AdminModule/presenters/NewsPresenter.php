<?php

namespace AdminModule;

use App\Presenters\BasePresenter;
use FrontModule\Components\NewComponent;
use Nette;
use App\Model;


class NewsPresenter extends ModuleBasePresenter
{

    /**
     * @var \FrontModule\Components\INewComponentFactory
     */
    private $newComponentFactory;

    /**
     * @var \Models\NewsModel
     */
    private $newsModel;

    /**
     * @var \Models\NewsPhotoModel
     */
    private $newsPhotoModel;

    private $editedNew;

    public function renderDefault()
    {
        $news = $this->newsModel->findAllNews();
        $this->template->news = $news;
        $this->template->newsCount = count($news);
    }

    public function actionEdit($id) {
        $this->editedNew = $this->newsModel->findNewsById($id);
    }

    public function actionRemove($id) {
        $this->newsModel->removeNewById($id);
        $this->setView('default');
    }

    public function actionRemoveNewPhoto($id) {
        $this->newsModel->removeNewPhotoById($id);
        $this->setView('default');
    }

    public function renderEdit()
    {
        $this->template->new = $this->editedNew;
        $this->template->newPhotos = $this->newsPhotoModel->findPhotosByNewId($this->editedNew["id"]);
    }

    public final function injectNewsModel(\Models\NewsModel $newsModel) {
        $this->newsModel = $newsModel;
    }

    public final function injectNewsPhotoModel(\Models\NewsPhotoModel $newsPhotoModel) {
        $this->newsPhotoModel = $newsPhotoModel;
    }

    public final function injectCreateNewComponentFactory(\FrontModule\Components\INewComponentFactory $newComponentFactory) {
        $this->newComponentFactory = $newComponentFactory;
    }

    /**
     * @return \FrontModule\Components\NewComponent
     */
    protected function createComponentNewFormComponent() {
        $control = $this->newComponentFactory->create($this->newsModel, $this->newsPhotoModel, null);
        $control->onFormSave[] = function (NewComponent $control) {
            $this->flashMessage('Nový příspěvek byl uložen.', BasePresenter::FLASH_MESSAGE_SUCCESS);
            $this->redirect('this');
        };

        return $control;
    }

    /**
     * @return \FrontModule\Components\NewComponent
     */
    protected function createComponentEditFormComponent() {
        $control = $this->newComponentFactory->create($this->newsModel, $this->newsPhotoModel, $this->editedNew);
        $control->onFormSave[] = function (NewComponent $control) {
            $this->flashMessage('Příspěvek byl upraven.', BasePresenter::FLASH_MESSAGE_SUCCESS);
            $this->redirect('News:default');
        };

        return $control;
    }

}
