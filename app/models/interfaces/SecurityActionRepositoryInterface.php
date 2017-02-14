<?php

//###INSERT-LICENSE-HERE###

namespace Models\Interfaces;

interface SecurityActionRepositoryInterface {

    public function findAllActions();

    public function findPermissionByUser($userId);

    public function findUserByUsername($username);

    public function findSalt();
}
