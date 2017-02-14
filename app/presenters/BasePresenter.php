<?php

namespace App\Presenters;

use App\Model;
use \Nette\Security\User;
use Security\Permission;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends \Nette\Application\UI\Presenter
{
    const FLASH_MESSAGE_SUCCESS = 'success';
    const FLASH_MESSAGE_INFO = 'info';
    const FLASH_MESSAGE_WARNING = 'warning';
    const FLASH_MESSAGE_ERROR = 'danger';

    /**
     * @var \Models\WarningsModel
     */
    public $warningsModel;

    /**
     * @inject
     * @var \Models\Security\SecurityManager
     */
    public $securityManager;

    protected function startup() {
        parent::startup();
        $warnings = $this->warningsModel->findAllWarnings();
        $this->template->warning = $warnings[0];
    }

    protected function getSignalModifiedName() {
        $signal = $this->getSignal();
        return $signal[1] . '!';
    }

    public function flashMessage($message, $type = self::FLASH_MESSAGE_INFO) {
        return parent::flashMessage($message, $type);
    }

    protected function isSignal() {
        return $this->getSignal() !== NULL;
    }

    public final function injectWarningsModel(\Models\WarningsModel $warningsModel) {
        $this->warningsModel = $warningsModel;
    }
}
