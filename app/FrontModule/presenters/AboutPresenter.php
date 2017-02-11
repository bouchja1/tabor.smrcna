<?php

namespace FrontModule;

use Nette;
use App\Model;


class AboutPresenter extends \Nette\Application\UI\Presenter
{

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

}
