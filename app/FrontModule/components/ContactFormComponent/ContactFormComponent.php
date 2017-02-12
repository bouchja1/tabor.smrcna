<?php

//###INSERT-LICENSE-HERE###

namespace FrontModule\Components;

use \Nette\Application\UI\Form,
    Components\BaseComponent;

final class ContactFormComponent extends BaseComponent {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @return \Nette\Application\UI\Form
     */
    public function createComponentContactForm() {
        $form = new \FrontModule\Forms\ContactForm();
        $form->onSuccess[] = [$this, 'processContactForm'];
        return $form;
    }

    public function processContactForm($form, $values) {
        try {
            $this->presenter->setSearchText(trim($values['searchText']));
            if ($this->presenter->isAjax()) {
//                $this->presenter->redrawControl('films');
            } else {
                //$this->redirect(":Front:Homepage:default", array("category" => $values['filmCategory'], "searchText" => $this->searchText));
                $this->redirect(":Front:Homepage:default");
            }
        } catch (\Exception $e) {
            $this->flashMessage('Odeslání selhalo.', \BasePresenter::FLASH_MESSAGE_ERROR);
            $form->addError($e->getMessage());
        }
    }

}
