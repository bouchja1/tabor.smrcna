<?php

//###INSERT-LICENSE-HERE###

namespace AdminModule\Forms;

use Nette\Application\UI\Form;

final class EmailReceiversForm extends \Nette\Application\UI\Form {

    public function __construct() {
        parent::__construct();

        $this->addText('email', 'E-mail:')
            ->setAttribute('placeholder', 'Váš e-mail');
        
        $this->addSubmit('submit', 'Odeslat');
    }

}
