<?php

namespace AdminModule;

use App\Presenters\BasePresenter;
use FrontModule\Components\HistoryComponent;
use Nette;
use App\Model;


class HistoryPresenter extends ModuleBasePresenter
{

    /**
     * @var \Models\HistoryModel
     */
    private $historyModel;

    /**
     * @var \Models\HistoryPhotoModel
     */
    private $historyPhotoModel;

    /**
     * @var \FrontModule\Components\IHistoryComponentFactory
     */
    private $historyComponentFactory;

    private $editedHistory;

    public function renderDefault()
    {
        $terms = $this->historyModel->findAllTerms();
        $this->template->terms = $terms;
    }

    public function actionEdit($id) {
        $this->editedHistory = $this->historyModel->findHistoryTermById($id);

    }

    public function actionRemove($id) {
        $this->historyModel->removeHistoryById($id);
        $this->setView('default');
    }

    public function actionRemoveTermPhoto($id) {
        $this->historyModel->removeHistoryPhotoById($id);
        $this->setView('default');
    }

    public function renderEdit()
    {
        $this->template->term = $this->editedHistory;
        $this->template->termPhotos = $this->historyPhotoModel->findPhotosByTermId($this->editedHistory["id"]);
    }

    public final function injectHistoryModel(\Models\HistoryModel $historyModel) {
        $this->historyModel = $historyModel;
    }

    public final function injectHistoryPhotoModel(\Models\HistoryPhotoModel $historyPhotoModel) {
        $this->historyPhotoModel = $historyPhotoModel;
    }

    public final function injectCreateHistoryComponentFactory(\FrontModule\Components\IHistoryComponentFactory $historyComponentFactory) {
        $this->historyComponentFactory = $historyComponentFactory;
    }

    /**
     * @return \FrontModule\Components\HistoryComponent
     */
    protected function createComponentNewHistoryFormComponent() {
        $control = $this->historyComponentFactory->create($this->historyModel, $this->historyPhotoModel, null);
        $control->onFormSave[] = function (HistoryComponent $control) {
            $this->flashMessage('Informace byly uloženy.', BasePresenter::FLASH_MESSAGE_SUCCESS);
            $this->redirect('this');
        };

        return $control;
    }

    /**
     * @return \FrontModule\Components\HistoryComponent
     */
    protected function createComponentEditHistoryFormComponent() {
        $control = $this->historyComponentFactory->create($this->historyModel, $this->historyPhotoModel, $this->editedHistory);
        $control->onFormSave[] = function (HistoryComponent $control) {
            $this->flashMessage('Informace byly upraveny.', BasePresenter::FLASH_MESSAGE_SUCCESS);
            $this->redirect('this');
        };

        return $control;
    }
}
