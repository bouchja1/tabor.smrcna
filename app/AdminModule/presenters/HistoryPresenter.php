<?php

namespace AdminModule;

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

    public function renderEdit()
    {
        $this->template->term = $this->editedHistory;
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
        return $this->historyComponentFactory->create($this->historyModel, $this->historyPhotoModel, null);
    }

    /**
     * @return \FrontModule\Components\HistoryComponent
     */
    protected function createComponentEditHistoryFormComponent() {
        return $this->historyComponentFactory->create($this->historyModel, $this->historyPhotoModel, $this->editedHistory);
    }
}
