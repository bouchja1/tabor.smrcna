<?php

//###INSERT-LICENSE-HERE###

namespace Security;

final class Permission extends \Nette\Security\Permission {

    const ROLE_ADMIN = 'admin';
    const GUEST = 'guest';

    public function __construct() {
        $this->addRoles();
        $this->addRecources();
        $this->allowRecources();
    }

    private function addRoles() {
        $this->addRole(self::GUEST);
        $this->addRole(self::ROLE_ADMIN);
    }

    private function addRecources() {
        $this->addResource('SignPresenter');

        // resources AdminModule
        $this->addResource('AdminModule\HomepagePresenter');
        $this->addResource('AdminModule\CurrentlyPresenter');
        $this->addResource('AdminModule\NewsPresenter');
        $this->addResource('AdminModule\WarningPresenter');
        $this->addResource('AdminModule\HistoryPresenter');
        $this->addResource('AdminModule\MailsPresenter');
        $this->addResource('AdminModule\LocationPresenter');

        // resources FrontModule
        $this->addResource('FrontModule\AboutPresenter');
        $this->addResource('FrontModule\CampPresenter');
        $this->addResource('FrontModule\ContactPresenter');
        $this->addResource('FrontModule\ErrorPresenter');
        $this->addResource('FrontModule\HomepagePresenter');
        $this->addResource('FrontModule\LocationPresenter');
    }

    private function allowRecources() {
        $this->allow(self::GUEST, 'SignPresenter', Permission::ALL);

        // privileges AdminModule
        $this->allow(self::ROLE_ADMIN, 'AdminModule\HomepagePresenter', Permission::ALL);
        $this->allow(self::ROLE_ADMIN, 'AdminModule\CurrentlyPresenter', Permission::ALL);
        $this->allow(self::ROLE_ADMIN, 'AdminModule\NewsPresenter', Permission::ALL);
        $this->allow(self::ROLE_ADMIN, 'AdminModule\WarningPresenter', Permission::ALL);
        $this->allow(self::ROLE_ADMIN, 'AdminModule\HistoryPresenter', Permission::ALL);
        $this->allow(self::ROLE_ADMIN, 'AdminModule\MailsPresenter', Permission::ALL);
        $this->allow(self::ROLE_ADMIN, 'AdminModule\LocationPresenter', Permission::ALL);

        // privileges FrontModule
        $this->allow(self::GUEST, 'FrontModule\AboutPresenter', Permission::ALL);
        $this->allow(self::GUEST, 'FrontModule\CampPresenter', Permission::ALL);
        $this->allow(self::GUEST, 'FrontModule\ContactPresenter', Permission::ALL);
        $this->allow(self::GUEST, 'FrontModule\ErrorPresenter', Permission::ALL);
        $this->allow(self::GUEST, 'FrontModule\HomepagePresenter', Permission::ALL);
        $this->allow(self::GUEST, 'FrontModule\LocationPresenter', Permission::ALL);
    }

}
