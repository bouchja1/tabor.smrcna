<?php

namespace FrontModule;

use App\Presenters\BasePresenter;
use FrontModule\Components\ContactFormComponent;
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
     * @var \Models\EmailReceiversModel
     */
    private $emailReceiversModel;

    /**
     * @var \Models\MailsModel
     */
    private $mailsModel;

    public final function injectContactFormComponentFactory(\FrontModule\Components\IContactFormComponentFactory $contactFormComponentFactory)
    {
        $this->contactFormComponentFactory = $contactFormComponentFactory;
    }

    public final function injectEmailReceiversModel(\Models\EmailReceiversModel $emailReceiversModel) {
        $this->emailReceiversModel = $emailReceiversModel;
    }

    public function renderDefault()
    {
        $this->template->anyVariable = 'any value';
    }

    /**
     * @return \FrontModule\Components\ContactFormComponent
     */
    protected function createComponentContactFormComponent()
    {
        $control = $this->contactFormComponentFactory->create($this->mailsModel, $this->emailReceiversModel);
        $control->onContactFormSave[] = function (ContactFormComponent $control) {
            $this->flashMessage('Váše zpráva byla odeslána. Brzy se Vám ozveme.', BasePresenter::FLASH_MESSAGE_SUCCESS);
            $this->redirect('this');
            // nebo například přesměrujeme na detail dané kategorie
            // $this->redirect('detail', ['id' => $category->id]);
        };

        return $control;
    }

    public final function injectMailsModel(\Models\MailsModel $mailsModel)
    {
        $this->mailsModel = $mailsModel;
    }

}
