<?php

//###INSERT-LICENSE-HERE###

namespace AdminModule;

use AdminModule\Components\ISignComponentFactory;
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
		return $this->signComponentFactory->create();
	}

	public function renderDefault()
	{

	}

}
