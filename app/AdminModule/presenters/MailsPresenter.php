<?php

namespace AdminModule;

use Nette;
use App\Model;


class MailsPresenter extends ModuleBasePresenter
{

    /**
     * @var \Models\MailsModel
     */
    private $mailsModel;

    public function renderDefault()
    {
        $mails = $this->mailsModel->findAllMails();
        $this->template->mails = $mails;
        $this->template->mailsCount = count($mails);
    }

    public final function injectMailsModel(\Models\MailsModel $mailsModel) {
        $this->mailsModel = $mailsModel;
    }


}
