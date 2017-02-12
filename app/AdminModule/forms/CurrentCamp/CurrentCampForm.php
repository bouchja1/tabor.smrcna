<?php

//###INSERT-LICENSE-HERE###

namespace AdminModule\Forms;

use Nette\Application\UI\Form;

final class CurrentCampForm extends \Nette\Application\UI\Form {

    public function __construct($editedCurrentCamp) {
        parent::__construct();

        $this->addText('poster', 'Plakát:')
            ->setAttribute('placeholder', 'plakát')
            ->setRequired(TRUE)
            ->setDefaultValue($editedCurrentCamp["poster"]);

        $this->addTextArea('text', 'Text pro aktuální termín:')
            ->setAttribute('placeholder', 'sem zadejte text pro aktuální termín')
            ->setAttribute('class', 'mceEditor')
            ->setDefaultValue($editedCurrentCamp["text"]);

        $this->addSubmit('submit', 'Odeslat');
    }

}
