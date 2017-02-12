<?php

//###INSERT-LICENSE-HERE###

namespace Models;
use Models\Interfaces\SecurityActionRepositoryInterface;

/**
 * SecurityActionModel
 */
final class SecurityActionModel {

	/** @var SecurityActionRepositoryInterface */
	private $securityActionsStore;

	public function __construct(SecurityActionRepositoryInterface $securityActions) {
		$this->securityActionsStore = $securityActions;
	}

	public function findAllSecurityActions() {
		return $this->securityActionsStore->findAllActions();
	}

	public function findPermissionByUser($userId) {
		return $this->securityActionsStore->findPermissionByUser($userId);
	}

	public function findUserByUsername($username) {
		return $this->securityActionsStore->findUserByUsername($username);
	}

}
