<?php

//###INSERT-LICENSE-HERE###

namespace Security;

use Models\Security\SecurityManager;
use Models\SecurityActionModel;
use Nette\Security\AuthenticationException,
	Nette\Security\IAuthenticator,
	Nette\Security\Identity;
use Nette\Security\Passwords;

final class Authenticator extends \Nette\Object implements IAuthenticator {

	/** @var \Models\SecurityActionModel */
	private $securityActionModel;

	/**
	 * @var SecurityManager
	 */
	private $securityManager;

	public function __construct(SecurityActionModel $securityActionModel, SecurityManager $securityManager) {
		$this->securityActionModel = $securityActionModel;
		$this->securityManager = $securityManager;
	}

	/**
	 * Performs an authentication
	 *
	 * @param  array $credentials
	 * @return Identity
	 * @throws AuthenticationException
	 */
	public function authenticate(array $credentials) {
		list($username, $password) = $credentials;

		$row = $this->securityActionModel->findUserByUsername($username);

//		var_dump($row);
//		die();

		if (!$row) {
			throw new AuthenticationException("User " . $username . " not found.", self::IDENTITY_NOT_FOUND);
		} elseif (!$this->calculatePassword($password, $row["password"])) {
			throw new AuthenticationException("The password is incorrect.", self::INVALID_CREDENTIAL);
		}

		$arr = $row->toArray();
		unset($arr["password"]);
		return new Identity($row["id"], $row["action"], $arr);
	}

	private function calculatePassword($inputPassword, $dbStored) {
		return true;
	}

	/**
	 * Adds new user.
	 *
	 * @param  string $username
	 * @param  string $email
	 * @param  string $password
	 * @return int
	 */
	public function addUser($username, $email, $password,$role) {
		$this->userModel->insert([
			"username" => $username,
			"email" => $email,
			"role" => $role,
			"password" => Passwords::hash($password),
		]);
		$userId =  $this->userModel->getDatabase()->insertId();
		if ($role !== Permission::ROLE_ADMIN) {
			$this->securityManager->initializePrivileges($userId);
		}
		return $userId;
	}

	/**
	 * Edit user.
	 *
	 * @param  int    $id
	 * @param  string $username
	 * @param  string $email
	 * @param  string $password
	 * @return void
	 */
	public function editUser($id, $username, $email, $password,$role = NULL) {
		$updateData = [
			"id" => $id,
			"username" => $username,
			"email" => $email,
			
		];
		if ($role !== NULL) {
			$updateData["role"] = $role;
		}
		if ($password != "") {
			$updateData["password"] = Passwords::hash($password);
		}
		$user = $this->userModel->getById($id);
		if ($user->role == Permission::ROLE_ADMIN && $role != Permission::ROLE_ADMIN) {
			$this->securityManager->initializePrivileges($id);
		}
		$this->userModel->update($updateData);
	}

}
