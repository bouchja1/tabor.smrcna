<?php

//###INSERT-LICENSE-HERE###

namespace FrontModule\Components;

use App\Presenters\BasePresenter;
use \Nette\Application\UI\Form,
    Components\BaseComponent;
use Nette\Mail\Message;

final class CurrentCampComponent extends BaseComponent {

    /**
     * @var
     */
    public $currentCampModel;
    public $editedCurrentCamp;

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
                $this->currentCampModel->updateCurrentYearInfo($values);
            } else {
                /* @var $file FileUpload */
                $file = $values["poster"];

                try {
                    if ($file->isOk() && $file->isImage()) {
//                        $this->fileModel->begin();
//                        // generate name
//                        if (preg_match("/^(.*)\.(.*)$/", $file->getSanitizedName(), $nameParts)) {
//                            $name = Strings::webalize($nameParts[1]) . "." . $nameParts[2];
//                        } else {
//                            $name = Strings::webalize($file->getSanitizedName());
//                        }
//
//                        // if file already exists, add number to filename
//                        while ($this->fileModel->existsByName($name)) {
//                            preg_match('/(.*?)(?:(?:_([\d]+))?(\.[^.]+))?$/', $name, $matches);
//                            $index = isset($matches[2]) ? ((int) $matches[2]) + 1 : 1;
//                            $ext = isset($matches[3]) ? $matches[3] : '';
//                            $name = $matches[1] . '_' . $index . $ext;
//                        }
//
//                        $fileId = $this->fileManager->insert($name, FileModel::TYPE_IMAGE, $values);
//                        $file->move($this->uploadDir . "/" . $name);
//
//                        // resize all images to prevent errors when image is used in article gallery
//                        $image = $file->toImage();
//                        $image->resize($this->thumbnail["max_width"], $this->thumbnail["max_height"], \Nette\Utils\Image::SHRINK_ONLY)->save($this->uploadDir . "/thumbnail/" . $name);
//                        $image->resize($this->resized["max_width"], $this->resized["max_height"], \Nette\Utils\Image::SHRINK_ONLY)->save($this->uploadDir . "/resized/" . $name);
//
//                        $this->fileModel->commit();
//                        $dataFunction = $this->dataFunction;
//                        $responseString = '<option value="">--žádná--</option>';
//                        foreach ($dataFunction("cs") AS $key => $value) {
//                            $selected = ($key == $fileId) ? "selected" : "";
//                            $responseString .= '<option ' . $selected . ' value="' . $key . '">' . $value . '</option>';
//                        }
//                        $this->presenter->sendResponse(new \Nette\Application\Responses\TextResponse('<div id="data">' . $responseString . '</div>'));
                    } else {
                        $form->addError("Soubor se nepovedlo nahrát. Je soubor obrázek ve správném formátu?");
                    }
                } catch (AbortException $ex) {
                    throw $ex;
                } catch (Exception $ex) {
                    Debugger::log($ex);
                    $form->addError("Došlo k neznámé chybě.");
                }

                $this->currentCampModel->saveCurrentYearInfo($values);
            }
            if ($this->presenter->isAjax()) {
                $this->presenter->redrawControl('films');
            } else {
                $this->redirect(":Admin:Homepage:default");
            }
        } catch (\Exception $e) {
            $this->flashMessage('Ukládání aktuálního termínu selhalo.', BasePresenter::FLASH_MESSAGE_ERROR);
            $form->addError($e->getMessage());
        }
    }

}
