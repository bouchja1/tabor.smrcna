<?php

//###INSERT-LICENSE-HERE###

namespace AdminModule\Forms;

use Nette\Application\UI\Form;

final class WarningsForm extends \Nette\Application\UI\Form {

    public function __construct($editedWarning) {
        parent::__construct();

        $this->addText('title', 'Nadpis:')
            ->setAttribute('placeholder', 'sem zadejte nadpis (spíše kratší)')
            ->setRequired(TRUE)
            ->setDefaultValue($editedWarning["title"])
            ->addRule(Form::MAX_LENGTH, 'Vaše zpráva je příliš dlouhá', 50);

        $this->addTextArea('text', 'Text sdělení:')
            ->setAttribute('placeholder', 'sem zadejte sdělení')
            ->setAttribute('class', 'mceEditor')
            ->setDefaultValue($editedWarning["text"])
            ->addRule(Form::MAX_LENGTH, 'Vaše zpráva je příliš dlouhá', 255);

        $this->addSubmit('submit', 'Odeslat');
    }

}
