<?php

//###INSERT-LICENSE-HERE###

namespace FrontModule\Forms;

final class ContactForm extends \Nette\Application\UI\Form {

    public function __construct() {
        parent::__construct();

        $this->addText('email')
            ->setAttribute('placeholder', 'Váš e-mail:');

        $this->addText('name')
            ->setAttribute('placeholder', 'Vaše jméno:');

        $this->addText('message')
                ->setAttribute('placeholder', 'Zpráva');
        
        //$this->addHidden('filmCategory', $filmCategory);

        $this->addSubmit('submit', 'Odeslat');
    }

}
