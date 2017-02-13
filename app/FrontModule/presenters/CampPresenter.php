<?php

namespace FrontModule;

use Nette;
use App\Model;
use App\FrontModule\Presenters\ModuleBasePresenter;

class CampPresenter extends ModuleBasePresenter
{

	/**
	 * @var \Models\CurrentCampModel
	 */
	private $currentCampModel;

	public function renderDefault()
	{
		$current = $this->currentCampModel->findActiveCamp();
		if (sizeof($current) > 0) {
			$this->template->current = $current;
		} else {
			$this->template->current = null;
		}
	}

	public final function injectCurrentCampModel(\Models\CurrentCampModel $currentCampModel) {
		$this->currentCampModel = $currentCampModel;
	}
}
