<?php

namespace FrontModule;

use Nette;
use App\Model;


class CampPresenter extends \Nette\Application\UI\Presenter
{

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

}
