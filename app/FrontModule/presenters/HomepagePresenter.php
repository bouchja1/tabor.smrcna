<?php

namespace FrontModule;

use App\FrontModule\Presenters\ModuleBasePresenter;
use Nette;
use App\Model;


class HomepagePresenter extends ModuleBasePresenter
{

    /**
     * @var \Models\NewsModel
     */
    private $newsModel;

    /**
     * @inject
     * @var Nette\Utils\Paginator
     */
    public $paginator;

    public function actionDefault($pageNumber = 1) {
        // paginator
        $allNews = $this->newsModel->findAllNews();
        $this->paginator->setItemCount(count($allNews)); // celkový počet položek (např. článků)
        $this->paginator->setItemsPerPage(5); // počet položek na stránce
        $this->paginator->setPage($pageNumber); // číslo aktuální stránky, číslováno od 1
        $news = $this->newsModel->findPaginatedNews($this->paginator);
        $this->template->news = $news;
        $this->template->newsCount = count($allNews);
        $this->template->newsPagesCount = ceil(count($allNews) / 5);
        $this->template->paginator = $this->paginator;
    }

	public function renderDefault()
	{

	}

    public final function injectNewsModel(\Models\NewsModel $newsModel) {
        $this->newsModel = $newsModel;
    }


}
