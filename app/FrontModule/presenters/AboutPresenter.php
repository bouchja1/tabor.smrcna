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

    /**
     * @var \Models\HistoryPhotoModel
     */
    private $historyPhotoModel;

	public function renderDefault()
	{
        $terms = $this->historyModel->findAllTerms();
        foreach ($terms as &$term) {
            $termPhotos = $this->historyPhotoModel->findPhotosByTermId($term["id"]);
            $term["photos"] = $termPhotos;
        }
        $this->template->terms = $terms;
	}

    public final function injectHistoryModel(\Models\HistoryModel $historyModel) {
        $this->historyModel = $historyModel;
    }

    public final function injectHistoryPhotoModel(\Models\HistoryPhotoModel $historyPhotoModel) {
        $this->historyPhotoModel = $historyPhotoModel;
    }

}
