<?php

//###INSERT-LICENSE-HERE###

namespace FrontModule\Components;

use App\Presenters\BasePresenter;
use \Nette\Application\UI\Form,
    Components\BaseComponent;
use Nette\Mail\Message;
use Nette\Utils\Image;
use Nette\Utils\Strings;
use Tracy\Debugger;

final class CurrentCampComponent extends BaseComponent {

    /**
     * @var
     */
    public $currentCampModel;
    public $editedCurrentCamp;

    public $onFormSave;

    /**
     * @var string
     */
    private $uploadDir;

    public function __construct($currentCampModel, $editedCurrentCamp) {
        parent::__construct();
        $this->currentCampModel = $currentCampModel;
        $this->editedCurrentCamp = $editedCurrentCamp;
    }

    /**
     * @return \Nette\Application\UI\Form
     */
    public function createComponentCurrentCampForm() {
        $form = new \AdminModule\Forms\CurrentCampForm($this->editedCurrentCamp);
        $form->onSuccess[] = [$this, 'processCurrentCampForm'];
        return $form;
    }

    public function processCurrentCampForm($form, $values) {
        try {
            // We will store it to a database.
            if ($this->editedCurrentCamp != null) {
                $values["id"] = $this->editedCurrentCamp["id"];
                $file = $values["poster"];
                if ($file->size != null) {
                    $name = $this->uploadPoster($file, $form);
                } else {
                    $curr = $this->currentCampModel->findCurrentYearById($values["id"]);
                    $name = $curr["poster"];
                }
                unset($values->poster);
                $values["poster"] = $name;
                $this->currentCampModel->updateCurrentYearInfo($values);
            } else {
                /* @var $file FileUpload */
                $file = $values["poster"];
                $name = "";
                if ($file->size != null) {
                    unset($values->poster);
                    $name = $this->uploadPoster($file, $form);
                }
                $this->currentCampModel->saveCurrentYearInfo($values, $name);
            }
            if ($this->presenter->isAjax()) {
                $this->presenter->redrawControl('films');
            } else {
                $this->onFormSave($this);
            }
        } catch (\Exception $e) {
            $this->currentCampModel->rollbackTransaction();
            $this->flashMessage('Ukládání aktuálního termínu selhalo.', BasePresenter::FLASH_MESSAGE_ERROR);
            $form->addError($e->getMessage());
        }
    }

    public function uploadPoster($file, &$form) {
        try {
            if ($file->isOk() && $file->isImage()) {
                // generate name
                if (preg_match("/^(.*)\.(.*)$/", $file->getSanitizedName(), $nameParts)) {
                    $name = Strings::webalize($nameParts[1]) . "." . $nameParts[2];
                } else {
                    $name = Strings::webalize($file->getSanitizedName());
                }

                // if file already exists, add number to filename
                while ($this->currentCampModel->existsPictureByName($name)) {
                    preg_match('/(.*?)(?:(?:_([\d]+))?(\.[^.]+))?$/', $name, $matches);
                    $index = isset($matches[2]) ? ((int) $matches[2]) + 1 : 1;
                    $ext = isset($matches[3]) ? $matches[3] : '';
                    $name = $matches[1] . '_' . $index . $ext;
                }
                $file->move($this->uploadDir . "/" . $name);
                // resize all images to prevent errors when image is used in article gallery
                return $name;
            } else {
                $form->addError("Soubor se nepovedlo nahrát. Je soubor obrázek ve správném formátu?");
                throw new \Exception();
            }
        } catch (AbortException $ex) {
            throw $ex;
        } catch (Exception $ex) {
            $this->currentCampModel->rollbackTransaction();
            Debugger::log($ex);
            $form->addError("Došlo k neznámé chybě.");
        }
    }

    public function setUploadDir($uploadDir) {
        $this->uploadDir = $uploadDir;
    }

}
