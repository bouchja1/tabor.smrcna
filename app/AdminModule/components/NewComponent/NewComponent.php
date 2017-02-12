<?php

//###INSERT-LICENSE-HERE###

namespace FrontModule\Components;

use App\Presenters\BasePresenter;
use \Nette\Application\UI\Form,
    Components\BaseComponent;
use Nette\Mail\Message;

final class NewComponent extends BaseComponent {

    /**
     * @var
     */
    public $newsModel;
    public $editedNew;

    public function __construct($newsModel, $editedNew) {
        parent::__construct();
        $this->newsModel = $newsModel;
        $this->editedNew = $editedNew;
    }

    /**
     * @return \Nette\Application\UI\Form
     */
    public function createComponentNewForm() {
        $form = new \AdminModule\Forms\NewForm($this->editedNew);
        $form->onSuccess[] = [$this, 'processNewForm'];
        return $form;
    }

    public function processNewForm($form, $values) {
        try {
            // We will store it to a database.
            if ($this->editedNew != null) {
                $values["id"] = $this->editedNew["id"];
                $this->newsModel->updateNew($values);
            } else {
                $values["datetime"] = date('Y-m-d H:i:s');
                $this->newsModel->saveNew($values);
            }
            if ($this->presenter->isAjax()) {
                $this->presenter->redrawControl('films');
            } else {
                $this->redirect(":Admin:Homepage:default");
            }
        } catch (\Exception $e) {
            $this->flashMessage('Ukládání novinky selhalo.', BasePresenter::FLASH_MESSAGE_ERROR);
            $form->addError($e->getMessage());
        }
    }

}
