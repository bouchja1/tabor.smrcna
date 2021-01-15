<?php

//###INSERT-LICENSE-HERE###

namespace AdminModule\Forms;

use Nette\Application\UI\Form;

final class NewForm extends \Nette\Application\UI\Form {

    public function __construct($editedNew) {
        parent::__construct();

        $this->addText('title', 'Nadpis novinky:')
            ->setAttribute('placeholder', 'nadpis novinky')
            ->setRequired(TRUE)
            ->setDefaultValue($editedNew ? $editedNew["title"] : null);

        $this->addTextArea('text', 'Textové sdělení novinky:')
            ->setAttribute('placeholder', 'text novinky')
            ->setAttribute('class', 'mceEditor')
            ->setRequired(FALSE)
            ->setDefaultValue($editedNew ? $editedNew["text"] : null)
            ->addRule(Form::MAX_LENGTH, 'Vaše zpráva je příliš dlouhá', 10000);

        $this->addMultiUpload('files', 'Obrázky k novince')
            ->setRequired(FALSE);

        $this->addText('youtube_video', 'HTTP odkaz na YouTube video:')
            ->setAttribute('placeholder', 'odkaz na video')
            ->setDefaultValue($editedNew ? $editedNew["youtube_video"] : null)
            ->setRequired(FALSE);

        $this->addSubmit('submit', 'Odeslat');
    }

}
