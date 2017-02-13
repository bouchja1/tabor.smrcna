<?php

//###INSERT-LICENSE-HERE###

namespace AdminModule\Forms;

use Nette\Application\UI\Form;

final class LocationForm extends \Nette\Application\UI\Form {

    public function __construct($editedCamp) {
        parent::__construct();

        $this->addTextArea('text_about', 'O táboře:')
            ->setAttribute('placeholder', 'text o táboře')
            ->setAttribute('class', 'mceEditor')
            ->setDefaultValue($editedCamp["text_about"])
            ->addRule(Form::MAX_LENGTH, 'Vaše zpráva je příliš dlouhá', 50000);

        $this->addMultiUpload('files_about', 'Obrázky k textu o táboře')
            ->setRequired(FALSE);

        $this->addTextArea('text_surroundings', 'Okolí tábora:')
            ->setAttribute('placeholder', 'text okolí tábora')
            ->setAttribute('class', 'mceEditor')
            ->setDefaultValue($editedCamp["text_surroundings"])
            ->addRule(Form::MAX_LENGTH, 'Vaše zpráva je příliš dlouhá', 50000);

        $this->addMultiUpload('files_surroundings', 'Obrázky k textu okolí tábora')
            ->setRequired(FALSE);

        $this->addSubmit('submit', 'Odeslat');
    }

}
