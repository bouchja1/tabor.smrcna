<?php

namespace AdminModule;

use Nette;
use App\Model;


class CurrentlyPresenter extends ModuleBasePresenter
{

    /**
     * @var \FrontModule\Components\ICurrentCampComponentFactory
     */
    private $currentCampComponentFactory;

    private $editedCurrentCamp;

    /**
     * @var \Models\CurrentCampModel
     */
    private $currentCampModel;

	public function renderDefault()
	{
        $current = $this->currentCampModel->findAllCamps();
        if (sizeof($current) > 0) {
            $this->template->current = $current;
        } else {
            $this->template->current = null;
        }
	}

    public function actionEdit($id) {
        $this->editedCurrentCamp = $this->currentCampModel->findCurrentYearById($id);
    }

    public function renderEdit()
    {
        $this->template->currentToEdit = $this->editedCurrentCamp;
    }

    public function actionActivate($id) {
        $this->currentCampModel->activateCurrentYearById($id);
        $this->setView('default');
    }

    public function actionRemove($id) {
        $this->currentCampModel->removeCurrentYearById($id);
        $this->setView('default');
    }

    public final function injectCurrentCampModel(\Models\CurrentCampModel $currentCampModel) {
        $this->currentCampModel = $currentCampModel;
    }

    public final function injectCreateCurrentCampComponentFactory(\FrontModule\Components\ICurrentCampComponentFactory $currentCampComponentFactory) {
        $this->currentCampComponentFactory = $currentCampComponentFactory;
    }

    /**
     * @return \FrontModule\Components\CurrentCampComponent
     */
    protected function createComponentCurrentCampFormComponent() {
        return $this->currentCampComponentFactory->create($this->currentCampModel, null);
    }

    /**
     * @return \FrontModule\Components\CurrentCampComponent
     */
    protected function createComponentEditCurrentCampFormComponent() {
        return $this->currentCampComponentFactory->create($this->currentCampModel, $this->editedCurrentCamp);
    }
}
