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

final class NewComponent extends BaseComponent {

    /**
     * @var
     */
    public $newsModel;
    public $newsPhotoModel;
    public $editedNew;

    /**
     * @var string
     */
    private $uploadDir;
    /**
     * @var array(max_width, max_height)
     */
    private $thumbnail;

    /**
     * @var array(max_width, max_height)
     */
    private $resized;

    public function __construct($newsModel, $newsPhotoModel, $editedNew) {
        parent::__construct();
        $this->newsModel = $newsModel;
        $this->newsPhotoModel = $newsPhotoModel;
        $this->editedNew = $editedNew;
    }

    /**
     * @return \Nette\Application\UI\Form
     */
    public function createComponentNewForm() {
        $form = new \AdminModule\Forms\NewForm($this->editedNew);
        $form->onSuccess[] = [$this, 'processNewForm'];
        return $form;
    }

    public function processNewForm($form, $values) {
        try {
            // We will store it to a database.
            if ($this->editedNew != null) {
                $values["id"] = $this->editedNew["id"];
                $file = $values["files"];
                unset($values->files);
                $this->newsModel->beginTransaction();
                $filesCount = sizeof($file);
                for ($i = 0; $i < $filesCount; $i++) {
                    $this->uploadPicture($file[$i], $form, $values["id"]);
                }
                $this->newsModel->updateNew($values);
                $this->newsModel->commitTransaction();
            } else {
                $values["datetime"] = date('Y-m-d H:i:s');
                /* @var $file FileUpload */
                $file = $values["files"];
                unset($values->files);

                $this->newsModel->beginTransaction();
                $newsId = $this->newsModel->saveNew($values);
                $filesCount = sizeof($file);

                for ($i = 0; $i < $filesCount; $i++) {
                    $this->uploadPicture($file[$i], $form, $newsId);
                }
                $this->newsModel->commitTransaction();
            }
            if ($this->presenter->isAjax()) {
                $this->presenter->redrawControl('films');
            } else {
                $this->redirect(":Admin:Homepage:default");
            }
        } catch (\Exception $e) {
            $this->newsModel->rollbackTransaction();
            $this->flashMessage('Ukládání novinky selhalo.', BasePresenter::FLASH_MESSAGE_ERROR);
            $form->addError($e->getMessage());
        }
    }

    public function uploadPicture($file, &$form, $newsId)
    {
        try {
            if ($file->isOk() && $file->isImage()) {
                // generate name
                if (preg_match("/^(.*)\.(.*)$/", $file->getSanitizedName(), $nameParts)) {
                    $name = Strings::webalize($nameParts[1]) . "." . $nameParts[2];
                } else {
                    $name = Strings::webalize($file->getSanitizedName());
                }

                // if file already exists, add number to filename
                while ($this->newsPhotoModel->existsByName($name)) {
                    preg_match('/(.*?)(?:(?:_([\d]+))?(\.[^.]+))?$/', $name, $matches);
                    $index = isset($matches[2]) ? ((int) $matches[2]) + 1 : 1;
                    $ext = isset($matches[3]) ? $matches[3] : '';
                    $name = $matches[1] . '_' . $index . $ext;
                }
                $this->newsPhotoModel->savePhoto($name, $newsId);
                $file->move($this->uploadDir . "/" . $name);

                // resize all images to prevent errors when image is used in article gallery
                $image = $file->toImage();
                $image->resize(NULL, $this->thumbnail["max_height"], Image::FIT)->save($this->uploadDir . "/thumbnail/" . $name);
            } else {
                $form->addError("Jeden ze souborů se nepovedlo nahrát. Je obrázek ve správném formátu?");
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

    public function setThumbnail(array $thumbnail) {
        $this->thumbnail = $thumbnail;
    }

    public function setResized(array $resized) {
        $this->resized = $resized;
    }

}
