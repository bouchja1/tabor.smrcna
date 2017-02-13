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

final class LocationComponent extends BaseComponent
{

    /**
     * @var
     */
    public $locationModel;
    public $locationPhotoModel;
    public $editedCamp;

    /**
     * @var string
     */
    private $uploadDir;

    /**
     * @var array(max_width, max_height)
     */
    private $thumbnail;

    public function __construct($locationModel, $locationPhotoModel, $editedCamp)
    {
        parent::__construct();
        $this->locationModel = $locationModel;
        $this->locationPhotoModel = $locationPhotoModel;
        $this->editedCamp = $editedCamp;
    }

    /**
     * @return \Nette\Application\UI\Form
     */
    public function createComponentLocationForm()
    {
        $form = new \AdminModule\Forms\LocationForm($this->editedCamp);
        $form->onSuccess[] = [$this, 'processLocationForm'];
        return $form;
    }

    public function processLocationForm($form, $values)
    {
        try {
            // We will store it to a database.
            $values["id"] = $this->locationModel->findLocation()["id"];
            var_dump($values["id"]);
            $fileSurroundings = $values["files_surroundings"];
            $fileAbout = $values["files_about"];
            unset($values->files_about);
            unset($values->files_surroundings);
            $this->locationModel->beginTransaction();
            $filesAboutCount = sizeof($fileAbout);
            $filesSurrCount = sizeof($fileSurroundings);
            for ($i = 0; $i < $filesAboutCount; $i++) {
                $this->uploadPicture($fileAbout[$i], $form, "ABOUT");
            }
            for ($j = 0; $j < $filesSurrCount; $j++) {
                $this->uploadPicture($fileSurroundings[$j], $form, "SURROUNDINGS");
            }
            $this->locationModel->updateLocation($values);
            $this->locationModel->commitTransaction();
            if ($this->presenter->isAjax()) {
                $this->presenter->redrawControl('films');
            } else {
                $this->redirect("Admin:Location:default");
            }
        } catch (\Exception $e) {
            $this->locationModel->rollbackTransaction();
            $this->flashMessage('Vkládání položky do historie selhalo.', BasePresenter::FLASH_MESSAGE_ERROR);
            $form->addError($e->getMessage());
        }
    }

    public function uploadPicture($file, &$form, $type)
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
                while ($this->locationPhotoModel->existsByName($name)) {
                    preg_match('/(.*?)(?:(?:_([\d]+))?(\.[^.]+))?$/', $name, $matches);
                    $index = isset($matches[2]) ? ((int) $matches[2]) + 1 : 1;
                    $ext = isset($matches[3]) ? $matches[3] : '';
                    $name = $matches[1] . '_' . $index . $ext;
                }
                $this->locationPhotoModel->savePhoto($name, $type);
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
            $this->locationModel->rollbackTransaction();
            Debugger::log($ex);
            $form->addError("Došlo k neznámé chybě.");
        }
    }

    public function setUploadDir($uploadDir)
    {
        $this->uploadDir = $uploadDir;
    }

    public function setThumbnail(array $thumbnail) {
        $this->thumbnail = $thumbnail;
    }

}
