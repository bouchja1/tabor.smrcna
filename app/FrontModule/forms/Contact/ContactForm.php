<?php

//###INSERT-LICENSE-HERE###

namespace FrontModule\Forms;

use Nette\Application\UI\Form;

final class ContactForm extends \Nette\Application\UI\Form {

    public function __construct() {
        parent::__construct();

        $this->addText('email', 'Váš e-mail:')
            ->setAttribute('placeholder', 'Váš e-mail');

        $this->addText('name', 'Vaše jméno:')
            ->setAttribute('placeholder', 'Vaše jméno');

        $this->addTextArea('message', 'Zpráva:')
            ->setAttribute('placeholder', 'Zpráva')
            ->setRequired(TRUE)
            ->addRule(Form::MAX_LENGTH, 'Vaše zpráva je příliš dlouhá', 10000);
        
        $this->addSubmit('submit', 'Odeslat');
    }

}
