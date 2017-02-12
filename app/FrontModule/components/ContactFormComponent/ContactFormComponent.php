<?php

//###INSERT-LICENSE-HERE###

namespace FrontModule\Components;

use App\Presenters\BasePresenter;
use \Nette\Application\UI\Form,
    Components\BaseComponent;
use Nette\Mail\Message;

final class ContactFormComponent extends BaseComponent {

    /**
     * @var
     */
    public $mailer;
    public $mailsModel;

    public function __construct($mailsModel) {
        parent::__construct();
        $this->mailsModel = $mailsModel;
    }

    /**
     * @return \Nette\Application\UI\Form
     */
    public function createComponentContactForm() {
        $form = new \FrontModule\Forms\ContactForm();
        $form->onSuccess[] = [$this, 'processContactForm'];
        return $form;
    }

    public function processContactForm($form, $values) {
        try {
            // Lets send an email.
            $mail = new Message();
            $mail->setFrom($values["email"])
                ->addTo('jan.bouchner@gmail.com')
                ->setSubject('Email z webu taborsmrcna.cz')
                ->setBody($values["message"]);
            $this->mailer->send($mail);
            // We will store it to a database.
            $this->mailsModel->saveMail($values);
            if ($this->presenter->isAjax()) {
                $this->presenter->redrawControl('films');
            } else {
                $this->redirect(":Front:Homepage:default");
            }
        } catch (\Exception $e) {
            $this->flashMessage('Odeslání mailu selhalo.', BasePresenter::FLASH_MESSAGE_ERROR);
            $form->addError($e->getMessage());
        }
    }

    public function setMailer($mailer) {
        $this->mailer = $mailer;
    }


}
