<?php

namespace FrontModule;

use Nette;
use App\Model;
use App\FrontModule\Presenters\ModuleBasePresenter;

class CampPresenter extends ModuleBasePresenter
{

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

}
