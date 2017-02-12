<?php

//###INSERT-LICENSE-HERE###

namespace FrontModule\Components;

use App\Presenters\BasePresenter;
use \Nette\Application\UI\Form,
    Components\BaseComponent;
use Nette\Mail\Message;

final class WarningComponent extends BaseComponent {

    /**
     * @var
     */
    public $warningsModel;
    public $editedWarning;

    public function __construct($warningsModel, $editedWarning) {
        parent::__construct();
        $this->warningsModel = $warningsModel;
        $this->editedWarning = $editedWarning;
    }

    /**
     * @return \Nette\Application\UI\Form
     */
    public function createComponentWarningsForm() {
        $form = new \AdminModule\Forms\WarningsForm($this->editedWarning);
        $form->onSuccess[] = [$this, 'processWarningsForm'];
        return $form;
    }

    public function processWarningsForm($form, $values) {
        try {
            // We will store it to a database.
            if ($this->editedWarning != null) {
                $values["id"] = $this->editedWarning["id"];
                $this->warningsModel->updateWarning($values);
            } else {
                $this->warningsModel->saveWarning($values);
            }
            $this->presenter->flashMessage("Upozornění bylo uloženo.", "success");
            if ($this->presenter->isAjax()) {
                $this->presenter->redrawControl('films');
            } else {
                $this->redirect(":Admin:Homepage:default");
            }
        } catch (\Exception $e) {
            $this->flashMessage('Vkládání upozornění selhalo.', BasePresenter::FLASH_MESSAGE_ERROR);
            $form->addError($e->getMessage());
        }
    }

}
