<?php

//###INSERT-LICENSE-HERE###

namespace AdminModule;

use Security\Permission;


abstract class ModuleBasePresenter extends \App\Presenters\BasePresenter {

	/**
	 * @inject
	 * @var \Models\Security\SecurityManager
	 */
	public $securityManager;
	
	protected function startup() {
		parent::startup();
		$user = $this->getUser();
//		var_dump($user);
//		die();
		$this->checkPermission($user);
	}
	
	protected function beforeRender() {
		parent::beforeRender();
	}

	protected function checkPermission(\Nette\Security\User $user) {
		//$this->checkSignalPermission($user);
		$this->checkActionPermission($user);
	}

	protected function checkSignalPermission(\Nette\Security\User $user) {
		if ($this->isSignalReceiver($this)) {
			if (!$user->isAllowed($this->reflection->name, $this->getSignalModifiedName())) {
				$this->flashMessage(_('Nemáte právo vykonat požadovanou akci!'), self::FLASH_MESSAGE_ERROR);
				$this->redirect('this');
			}
		}
	}

	protected function checkActionPermission(\Nette\Security\User $user) {
		if (!$user->isAllowed($this->reflection->name, $this->getAction())) {
			$this->flashMessage(_('Nemáte právo vykonat požadovanou akci!'), self::FLASH_MESSAGE_ERROR);

			// warning: $user->loggedIn() check is mandatory, because $user->getId is present even user is not logged
			if ($user->isLoggedIn()) {
				$link = $this->securityManager->getAllowedDefaultLink($user->getId());
			} else {
				$link = $this->securityManager->getAllowedDefaultLink(null);
			}
			$this->redirect($link);
		}
	}
}
