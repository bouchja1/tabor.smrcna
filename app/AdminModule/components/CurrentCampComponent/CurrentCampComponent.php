<?php

//###INSERT-LICENSE-HERE###

namespace FrontModule\Components;

use App\Presenters\BasePresenter;
use \Nette\Application\UI\Form,
    Components\BaseComponent;
use Nette\Mail\Message;

final class CurrentCampComponent extends BaseComponent {

    /**
     * @var
     */
    public $currentCampModel;
    public $editedCurrentCamp;

    public function __construct($currentCampModel, $editedCurrentCamp) {
        parent::__construct();
        $this->currentCampModel = $currentCampModel;
        $this->editedCurrentCamp = $editedCurrentCamp;
    }

    /**
     * @return \Nette\Application\UI\Form
     */
    public function createComponentCurrentCampForm() {
        $form = new \AdminModule\Forms\CurrentCampForm($this->editedCurrentCamp);
        $form->onSuccess[] = [$this, 'processCurrentCampForm'];
        return $form;
    }

    public function processCurrentCampForm($form, $values) {
        try {
            // We will store it to a database.
            if ($this->editedCurrentCamp != null) {
                $values["id"] = $this->editedCurrentCamp["id"];
                $this->currentCampModel->updateCurrentYearInfo($values);
            } else {
                $this->currentCampModel->saveCurrentYearInfo($values);
            }
            if ($this->presenter->isAjax()) {
                $this->presenter->redrawControl('films');
            } else {
                $this->redirect(":Admin:Homepage:default");
            }
        } catch (\Exception $e) {
            $this->flashMessage('Ukládání aktuálního termínu selhalo.', BasePresenter::FLASH_MESSAGE_ERROR);
            $form->addError($e->getMessage());
        }
    }

}
