<?php

//###INSERT-LICENSE-HERE###

namespace AdminModule\Components;

use App\Presenters\BasePresenter;
use Models\Security\SecurityManager;
use \Nette\Application\UI\Form,
    Components\BaseComponent;
use Nette\Security\AuthenticationException;

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
            try {
                $this->presenter->getUser()->login($values->username, $values->password);
            } catch (AuthenticationException $ex) {
                throw $ex;
            }
            $this->presenter->restoreRequest([$this->presenter, 'backlink']);
            $this->redirectToAllowedPage();
        } catch (AuthenticationException $e) {
            $this->presenter->flashMessage('Přihlašování selhalo: ' . $e->getMessage(), BasePresenter::FLASH_MESSAGE_ERROR);
            $this->presenter->redirect(":Admin:Sign:default");
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
