<?php

namespace AdminModule;

use AdminModule\Components\EmailReceiversComponent;
use App\Presenters\BasePresenter;
use Nette;
use App\Model;


class MailsPresenter extends ModuleBasePresenter
{

    /**
     * @var \AdminModule\Components\IEmailReceiversComponentFactory
     */
    private $emailReceiversComponentFactory;

    /**
     * @var \Models\MailsModel
     */
    private $mailsModel;

    /**
     * @var \Models\EmailReceiversModel
     */
    private $emailReceiversModel;

    public function actionRemove($id)
    {
        $this->emailReceiversModel->removeReceiverById($id);
        $this->setView('default');
    }

    public function renderDefault()
    {
        $mails = $this->mailsModel->findAllMails();
        $mailReceivers = $this->emailReceiversModel->findAllReceivers();
        $this->template->mails = $mails;
        $this->template->receivers = $mailReceivers;
        $this->template->mailsCount = count($mails);
    }

    public final function injectMailsModel(\Models\MailsModel $mailsModel) {
        $this->mailsModel = $mailsModel;
    }

    public final function injectEmailReceiversModel(\Models\EmailReceiversModel $emailReceiversModel) {
        $this->emailReceiversModel = $emailReceiversModel;
    }

    public final function injectCreateEmailReceiversComponentFactory(\AdminModule\Components\IEmailReceiversComponentFactory $emailReceiversComponentFactory) {
        $this->emailReceiversComponentFactory = $emailReceiversComponentFactory;
    }

    /**
     * @return \AdminModule\Components\EmailReceiversComponent
     */
    protected function createComponentEmailReceiversFormComponent() {
        $control = $this->emailReceiversComponentFactory->create($this->emailReceiversModel);
        $control->onFormSave[] = function (EmailReceiversComponent $control) {
            $this->flashMessage('Upozornění byloNový příjemce táborových mailů byl v pořádku uložen.', BasePresenter::FLASH_MESSAGE_SUCCESS);
            $this->redirect('this');
        };

        return $control;
    }
}
