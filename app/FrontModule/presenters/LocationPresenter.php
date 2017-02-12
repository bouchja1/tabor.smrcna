<?php

namespace FrontModule;

use Nette;
use App\Model;
use App\FrontModule\Presenters\ModuleBasePresenter;

class LocationPresenter extends ModuleBasePresenter
{

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

}
