<?php

//###INSERT-LICENSE-HERE###

namespace AdminModule\Forms;

use Nette\Application\UI\Form;

final class SignForm extends \Nette\Application\UI\Form {

    public function __construct() {
        parent::__construct();

        $this->addText('username', 'Uživatelské jméno:')
            ->setRequired();
        $this->addPassword('password', 'Heslo:')
            ->setRequired();
        $this->addSubmit('submit', 'Přihlásit');
    }

}
