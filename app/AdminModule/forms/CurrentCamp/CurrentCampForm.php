<?php

//###INSERT-LICENSE-HERE###

namespace AdminModule\Forms;

use Nette\Application\UI\Form;

final class CurrentCampForm extends \Nette\Application\UI\Form {

    public function __construct($editedCurrentCamp) {
        parent::__construct();

        $this->addUpload("poster", "Obrázek plakátu")
            ->addRule(Form::IMAGE, "Musí být obrázek")
            ->addRule(Form::MAX_FILE_SIZE, "Maximální velikost souboru je 512 kB.", 512 * 1024);

        $this->addTextArea('text', 'Text pro aktuální termín:')
            ->setAttribute('placeholder', 'sem zadejte text pro aktuální termín')
            ->setAttribute('class', 'mceEditor')
            ->setDefaultValue($editedCurrentCamp["text"]);

        $this->addSubmit('submit', 'Odeslat');
    }

}
