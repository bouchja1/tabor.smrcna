<?php

namespace FrontModule;

use Nette;
use App\Model;


class ContactPresenter extends \Nette\Application\UI\Presenter
{

	/**
	 * @var \FrontModule\Components\IContactFormComponentFactory
	 */
	private $contactFormComponentFactory;

	public final function injectContactFormComponentFactory(\FrontModule\Components\IContactFormComponentFactory $contactFormComponentFactory) {
		$this->contactFormComponentFactory = $contactFormComponentFactory;
	}

	public function renderDefault()
	{
		$this->template->anyVariable = 'any value';
	}

	/**
	 * @return \FrontModule\Components\ContactFormComponent
	 */
	protected function createComponentContactFormComponent() {
		return $this->contactFormComponentFactory->create();
	}

}
