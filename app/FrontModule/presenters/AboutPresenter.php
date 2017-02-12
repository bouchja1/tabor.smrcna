<?php

namespace FrontModule;

use Nette;
use App\Model;


class AboutPresenter extends \Nette\Application\UI\Presenter
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
