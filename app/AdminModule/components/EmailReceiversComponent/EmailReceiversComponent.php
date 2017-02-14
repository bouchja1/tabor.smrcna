<?php

//###INSERT-LICENSE-HERE###

namespace AdminModule\Components;

use App\Presenters\BasePresenter;
use \Nette\Application\UI\Form,
    Components\BaseComponent;
use Nette\Mail\Message;

final class EmailReceiversComponent extends BaseComponent {

    /**
     * @var
     */
    public $emailReceiversModel;

    public $onFormSave;

    public function __construct($emailReceiversModel) {
        parent::__construct();
        $this->emailReceiversModel = $emailReceiversModel;
    }

    /**
     * @return \Nette\Application\UI\Form
     */
    public function createComponentEmailReceiversForm() {
        $form = new \AdminModule\Forms\EmailReceiversForm();
        $form->onSuccess[] = [$this, 'processEmailReceiversForm'];
        return $form;
    }

    public function processEmailReceiversForm($form, $values) {
        try {
            // We will store it to a database.
                $this->emailReceiversModel->saveReceiver($values);
            if ($this->presenter->isAjax()) {
                $this->presenter->redrawControl('films');
            } else {
                $this->onFormSave($this);
            }
        } catch (\Exception $e) {
            $this->flashMessage('Přidání nového příjemce mailů selhalo.', BasePresenter::FLASH_MESSAGE_ERROR);
            $form->addError($e->getMessage());
        }
    }

}
