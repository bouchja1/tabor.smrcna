<?php

//###INSERT-LICENSE-HERE###

namespace AdminModule\Components;

use Models\Security\SecurityManager;
use \Nette\Application\UI\Form,
    Components\BaseComponent;

final class SignComponent extends BaseComponent {

    /**
     * @inject
     * @var SecurityManager
     */
    public $securityManager;

    public function __construct() {
        parent::__construct();
    }

    /**
     * @return \Nette\Application\UI\Form
     */
    public function createComponentSignForm() {
        $form = new \AdminModule\Forms\SignForm();
        $form->onSuccess[] = [$this, 'processSignForm'];
        return $form;
    }

    public function processSignForm($form, $values) {
        try {
            //$values = $form->getValues();
            $this->presenter->getUser()->setExpiration('+ 200 minutes', TRUE);
            $this->presenter->getUser()->login($values->username, $values->password);
            $this->presenter->restoreRequest($this->presenter->backlink);
            $this->redirectToAllowedPage();
        } catch (AuthenticationException $e) {
            $form->addError($e->getMessage());
        }
    }

    private function redirectToAllowedPage() {
        $user = $this->presenter->getUser();
        if (!$user->isInRole(\Security\Permission::ROLE_ADMIN)) {
            $link = $this->securityManager->getAllowedDefaultLink($user->getId());
        }
        else {
            $link = ':Admin:Homepage:default';
        }
        $this->presenter->redirect($link);
    }

}
