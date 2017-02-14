<?php

//###INSERT-LICENSE-HERE###

namespace AdminModule;

use AdminModule\Components\ISignComponentFactory;
use AdminModule\Components\SignComponent;
use App\Presenters\BasePresenter;
use Nette\Application\UI\Form;
use Nette\Security\Passwords;

class SignPresenter extends BasePresenter {

	/**
	 * @inject
	 * @var ISignComponentFactory
	 */
	public $signComponentFactory;

	/**
	 * Sign in form component factory.
	 * @return Form
	 */
	protected function createComponentLoginComponent() {
		$control = $this->signComponentFactory->create();
		return $control;
	}

	public function renderDefault()
	{

	}

}
