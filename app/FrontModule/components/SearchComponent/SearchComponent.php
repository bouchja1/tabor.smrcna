<?php

//###INSERT-LICENSE-HERE###

namespace FrontModule\Components;

use \Nette\Application\UI\Form,
    Components\BaseComponent;

final class SearchComponent extends BaseComponent {

    private $filmCategory;

    public function __construct($filmCategory) {
        parent::__construct();
        $this->filmCategory = $filmCategory;
    }

    /**
     * @return \Nette\Application\UI\Form
     */
    public function createComponentSearchForm() {
        $form = new \FrontModule\Forms\SearchForm($this->filmCategory);
        $form->onSuccess[] = callback($this, 'processSearchForm');
        return $form;
    }

    public function processSearchForm(Form $form) {
        try {
            $values = $form->getValues();
            $this->presenter->setSearchText(trim($values['searchText']));
            if ($this->presenter->isAjax()) {
                $this->presenter->redrawControl('films');
            } else {
                $this->redirect(":Front:Film:default", array("category" => $values['filmCategory'], "searchText" => $this->searchText));
            }
        } catch (\Exception $e) {
            $this->flashMessage($this->translator->translate('Vyhledávání selhalo.'), \BasePresenter::FLASH_MESSAGE_ERROR);
            $form->addError($e->getMessage());
        }
    }

}
