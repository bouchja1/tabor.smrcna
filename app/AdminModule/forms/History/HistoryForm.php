<?php

//###INSERT-LICENSE-HERE###

namespace AdminModule\Forms;

use Nette\Application\UI\Form;

final class HistoryForm extends \Nette\Application\UI\Form {

    public function __construct($editedHistory) {
        parent::__construct();

        $this->addText('year', 'Rok:')
            ->setAttribute('placeholder', 'rok kdy se tábor konal')
            ->setRequired(TRUE)
            ->setDefaultValue($editedHistory ? $editedHistory["year"] : null);

        $this->addText('title', 'Táborové téma:')
            ->setAttribute('placeholder', 'táborové téma')
            ->setRequired(TRUE)
            ->setDefaultValue($editedHistory ? $editedHistory["title"] : null);

        $this->addTextArea('text', 'Jak tábor probíhal:')
            ->setAttribute('placeholder', 'text tábora')
            ->setAttribute('class', 'mceEditor')
            ->setRequired(FALSE)
            ->setDefaultValue($editedHistory ? $editedHistory["text"] : null)
            ->addRule(Form::MAX_LENGTH, 'Vaše zpráva je příliš dlouhá', 10000);

        $this->addMultiUpload('files', 'Obrázky k historii')
            ->setRequired(FALSE);

        $this->addSubmit('submit', 'Odeslat');
    }

}
