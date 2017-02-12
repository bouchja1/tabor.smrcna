<?php

namespace FrontModule;

use Nette;
use App\Model;
use App\FrontModule\Presenters\ModuleBasePresenter;

class ContactPresenter extends ModuleBasePresenter
{

	/**
	 * @var \FrontModule\Components\IContactFormComponentFactory
	 */
	private $contactFormComponentFactory;

	/**
	 * @var \Models\MailsModel
	 */
	private $mailsModel;

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
		return $this->contactFormComponentFactory->create($this->mailsModel);
	}

	public final function injectMailsModel(\Models\MailsModel $mailsModel) {
		$this->mailsModel = $mailsModel;
	}

}
