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

final class HistoryComponent extends BaseComponent
{

    /**
     * @var
     */
    public $historyModel;
    public $historyPhotoModel;
    public $editedHistory;

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

    public function __construct($historyModel, $historyPhotoModel, $editedHistory)
    {
        parent::__construct();
        $this->historyModel = $historyModel;
        $this->historyPhotoModel = $historyPhotoModel;
        $this->editedHistory = $editedHistory;
    }

    /**
     * @return \Nette\Application\UI\Form
     */
    public function createComponentHistoryForm()
    {
        $form = new \AdminModule\Forms\HistoryForm($this->editedHistory);
        $form->onSuccess[] = [$this, 'processHistoryForm'];
        return $form;
    }

    public function processHistoryForm($form, $values)
    {
        try {
            // We will store it to a database.
            if ($this->editedHistory != null) {
                $values["id"] = $this->editedHistory["id"];
                $file = $values["files"];
                unset($values->files);
                $this->historyModel->beginTransaction();
                $filesCount = sizeof($file);
                for ($i = 0; $i < $filesCount; $i++) {
                    $this->uploadPicture($file[$i], $form, $values["id"]);
                }
                $this->historyModel->updateHistory($values);
                $this->historyModel->commitTransaction();
            } else {
                /* @var $file FileUpload */
                $file = $values["files"];
                unset($values->files);
                $this->historyModel->beginTransaction();
                $historyId = $this->historyModel->saveHistory($values);
                $filesCount = sizeof($file);
                for ($i = 0; $i < $filesCount; $i++) {
                    $this->uploadPicture($file[$i], $form, $historyId);
                }
                $this->historyModel->commitTransaction();
            }
            if ($this->presenter->isAjax()) {
                $this->presenter->redrawControl('films');
            } else {
                $this->redirect(":Admin:Homepage:default");
            }
        } catch (\Exception $e) {
            $this->historyModel->rollbackTransaction();
            $this->flashMessage('Vkládání položky do historie selhalo.', BasePresenter::FLASH_MESSAGE_ERROR);
            $form->addError($e->getMessage());
        }
    }

    public function uploadPicture($file, &$form, $historyId)
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
                while ($this->historyPhotoModel->existsByName($name)) {
                    preg_match('/(.*?)(?:(?:_([\d]+))?(\.[^.]+))?$/', $name, $matches);
                    $index = isset($matches[2]) ? ((int)$matches[2]) + 1 : 1;
                    $ext = isset($matches[3]) ? $matches[3] : '';
                    $name = $matches[1] . '_' . $index . $ext;
                }
                $this->historyPhotoModel->savePhoto($name, $historyId);
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

    public function setUploadDir($uploadDir)
    {
        $this->uploadDir = $uploadDir;
    }

    public function setThumbnail(array $thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    public function setResized(array $resized)
    {
        $this->resized = $resized;
    }

}
