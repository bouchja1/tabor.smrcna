<?php

namespace AdminModule;

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

    public function renderEdit()
    {
        $this->template->new = $this->editedNew;
    }

    public final function injectNewsModel(\Models\NewsModel $newsModel) {
        $this->newsModel = $newsModel;
    }

    public final function injectCreateNewComponentFactory(\FrontModule\Components\INewComponentFactory $newComponentFactory) {
        $this->newComponentFactory = $newComponentFactory;
    }

    /**
     * @return \FrontModule\Components\NewComponent
     */
    protected function createComponentNewFormComponent() {
        return $this->newComponentFactory->create($this->newsModel, null);
    }

    /**
     * @return \FrontModule\Components\NewComponent
     */
    protected function createComponentEditFormComponent() {
        return $this->newComponentFactory->create($this->newsModel, $this->editedNew);
    }

}
