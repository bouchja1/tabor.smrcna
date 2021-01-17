<?php

//###INSERT-LICENSE-HERE###

namespace FrontModule\Components;

use App\Presenters\BasePresenter;
use \Nette\Application\UI\Form,
    Components\BaseComponent;
use Nette\Mail\Message;
use Tracy\Debugger;

final class ContactFormComponent extends BaseComponent {

    /**
     * @var
     */
    public $mailer;
    public $mailsModel;

    private $smtpUsername;
    private $smtpPass;
    private $emailReceiversModel;

    public $onContactFormSave;

    public function __construct($mailsModel, $emailReceiversModel) {
        parent::__construct();
        $this->mailsModel = $mailsModel;
        $this->emailReceiversModel = $emailReceiversModel;
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
                ->setSubject('Email z webu taborsmrcna.cz')
                ->setBody("Zpráva odeslána z mailu: " . $values["email"] . " , obsah zprávy je: " . $values["message"]);

            $mailer = new \Nette\Mail\SmtpMailer([
                    'host' => 'mail.gigaserver.cz',
                    'username' => $this->smtpUsername,
                    'password' => $this->smtpPass,
                    'secure' => 'ssl',
            ]);
            $envMailer = $mailer;

            $receivers = $this->emailReceiversModel->findAllReceivers();

            foreach ($receivers as $receiver) {
                try {
                    $mail->addTo($receiver->email);
                    $envMailer->send($mail);
                    // We will store it to a database.
                    $this->mailsModel->saveMail($values);
                } catch (\Exception $e) {
                    Debugger::log("Mail was not sent.");
                }
            }

            if ($this->presenter->isAjax()) {
                $this->presenter->redrawControl('films');
            } else {
                $this->onContactFormSave($this);
            }
        } catch (\Exception $e) {
            $this->flashMessage('Odeslání zprávy selhalo.', BasePresenter::FLASH_MESSAGE_ERROR);
            $form->addError($e->getMessage());
        }
    }

    public function setMailer($mailer) {
        $this->mailer = $mailer;
    }

    public function setSmtpUsername($username) {
        $this->smtpUsername = $username;
    }

    public function setSmtpPass($pass) {
        $this->smtpPass = $pass;
    }


}
