<?php

//###INSERT-LICENSE-HERE###

namespace Components;

abstract class BaseComponent extends \Nette\Application\UI\Control {

    protected $autoSetupTemplateFile = TRUE;

    protected function createTemplate($class = NULL) {
        $template = parent::createTemplate($class);
        if ($this->autoSetupTemplateFile) {
            $template->setFile($this->getTemplateFilePath());
        }

        $template->addFilter('printf', 'sprintf');
        return $template;
    }

    public function render() {
        $this->template->render();
    }

    protected function getTemplateFilePath() {
        $reflection = $this->getReflection();
        $dir = dirname($reflection->getFileName());
        $filename = $reflection->getShortName() . '.latte';
        return $dir . \DIRECTORY_SEPARATOR . $filename;
    }

}
