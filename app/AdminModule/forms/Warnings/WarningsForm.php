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
            ->setDefaultValue($editedWarning ? $editedWarning["title"] : null)
            ->addRule(Form::MAX_LENGTH, 'Vaše zpráva je příliš dlouhá', 50);

        $this->addTextArea('text', 'Text sdělení:')
            ->setAttribute('placeholder', 'sem zadejte sdělení')
            ->setAttribute('class', 'mceEditor')
            ->setRequired(FALSE)
            ->setDefaultValue($editedWarning ? $editedWarning["text"] : null)
            ->addRule(Form::MAX_LENGTH, 'Vaše zpráva je příliš dlouhá', 255);

        $this->addSubmit('submit', 'Odeslat');
    }

}
