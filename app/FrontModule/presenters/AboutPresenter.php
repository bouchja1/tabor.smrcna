<?php

namespace FrontModule;

use Nette;
use App\Model;
use App\FrontModule\Presenters\ModuleBasePresenter;


class AboutPresenter extends ModuleBasePresenter
{

    /**
     * @var \Models\HistoryModel
     */
    private $historyModel;

	public function renderDefault()
	{
        $terms = $this->historyModel->findAllTerms();
        $this->template->terms = $terms;
	}

    public final function injectHistoryModel(\Models\HistoryModel $historyModel) {
        $this->historyModel = $historyModel;
    }

}
