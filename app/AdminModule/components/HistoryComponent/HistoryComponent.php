<?php

//###INSERT-LICENSE-HERE###

namespace FrontModule\Components;

use App\Presenters\BasePresenter;
use \Nette\Application\UI\Form,
    Components\BaseComponent;
use Nette\Mail\Message;

final class HistoryComponent extends BaseComponent {

    /**
     * @var
     */
    public $historyModel;
    public $editedHistory;

    public function __construct($historyModel, $editedHistory) {
        parent::__construct();
        $this->historyModel = $historyModel;
        $this->editedHistory = $editedHistory;
    }

    /**
     * @return \Nette\Application\UI\Form
     */
    public function createComponentHistoryForm() {
        $form = new \AdminModule\Forms\HistoryForm($this->editedHistory);
        $form->onSuccess[] = [$this, 'processHistoryForm'];
        return $form;
    }

    public function processHistoryForm($form, $values) {
        try {
            // We will store it to a database.
            if ($this->editedHistory != null) {
                $values["id"] = $this->editedHistory["id"];
                $this->historyModel->updateHistory($values);
            } else {
                $this->historyModel->saveHistory($values);
            }
            if ($this->presenter->isAjax()) {
                $this->presenter->redrawControl('films');
            } else {
                $this->redirect(":Admin:Homepage:default");
            }
        } catch (\Exception $e) {
            $this->flashMessage('Vkládání položky do historie selhalo.', BasePresenter::FLASH_MESSAGE_ERROR);
            $form->addError($e->getMessage());
        }
    }

}
