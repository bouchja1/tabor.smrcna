<?php

namespace AdminModule;

use Nette;
use App\Model;


class WarningPresenter extends ModuleBasePresenter
{

    /**
     * @var \FrontModule\Components\IWarningComponentFactory
     */
    private $warningComponentFactory;

    private $editedWarning;

    /**
     * @var \Models\WarningsModel
     */
    private $warningsModel;

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

    public final function injectWarningsModel(\Models\WarningsModel $warningsModel) {
        $this->warningsModel = $warningsModel;
    }

    public final function injectCreateWarningComponentFactory(\FrontModule\Components\IWarningComponentFactory $warningComponentFactory) {
        $this->warningComponentFactory = $warningComponentFactory;
    }

    /**
     * @return \FrontModule\Components\WarningComponent
     */
    protected function createComponentWarningsFormComponent() {
        return $this->warningComponentFactory->create($this->warningsModel, null);
    }

    /**
     * @return \FrontModule\Components\WarningComponent
     */
    protected function createComponentEditWarningsFormComponent() {
        return $this->warningComponentFactory->create($this->warningsModel, $this->editedWarning);
    }

}
