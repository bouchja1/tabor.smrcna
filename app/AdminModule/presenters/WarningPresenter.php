<?php

namespace AdminModule;

use App\Presenters\BasePresenter;
use FrontModule\Components\WarningComponent;
use Nette;
use App\Model;


class WarningPresenter extends ModuleBasePresenter
{

    /**
     * @var \FrontModule\Components\IWarningComponentFactory
     */
    private $warningComponentFactory;

    private $editedWarning;

    public function renderDefault()
    {
        $warnings = $this->warningsModel->findAllWarnings();
        $this->template->warnings = $warnings;
        $this->template->warningsCount = count($warnings);
    }

    public function actionEdit($id) {
        $this->editedWarning = $this->warningsModel->findWarningById($id);
    }

    public function renderEdit()
    {
        $this->template->warning = $this->editedWarning;
    }

    public final function injectCreateWarningComponentFactory(\FrontModule\Components\IWarningComponentFactory $warningComponentFactory) {
        $this->warningComponentFactory = $warningComponentFactory;
    }

    /**
     * @return \FrontModule\Components\WarningComponent
     */
    protected function createComponentWarningsFormComponent() {
        $control = $this->warningComponentFactory->create($this->warningsModel, null);
        $control->onFormSave[] = function (WarningComponent $control) {
            $this->flashMessage('Upozornění bylo v pořádku uloženo.', BasePresenter::FLASH_MESSAGE_SUCCESS);
            $this->redirect('this');
        };

        return $control;
    }

    /**
     * @return \FrontModule\Components\WarningComponent
     */
    protected function createComponentEditWarningsFormComponent() {
        $control = $this->warningComponentFactory->create($this->warningsModel, $this->editedWarning);
        $control->onFormSave[] = function (WarningComponent $control) {
            $this->flashMessage('Upozornění bylo upraveno.', BasePresenter::FLASH_MESSAGE_SUCCESS);
            $this->redirect('this');
        };

        return $control;
    }

}
