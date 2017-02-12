<?php

namespace AdminModule;

use Nette;
use App\Model;


class CurrentlyPresenter extends ModuleBasePresenter
{

    /**
     * @var \Models\NewsModel
     */
    private $newsModel;

	public function renderDefault()
	{
        $news = $this->newsModel->findAllNews();
        $this->template->news = $news;
        $this->template->newsCount = count($news);
	}

    public final function injectNewsModel(\Models\NewsModel $newsModel) {
        $this->newsModel = $newsModel;
    }


}
