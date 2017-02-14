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
			throw new AuthenticationException("Neznámý uživatel.", self::IDENTITY_NOT_FOUND);
		} elseif (!$this->calculatePassword($password, $row["password"])) {
			throw new AuthenticationException("Chybné heslo.", self::INVALID_CREDENTIAL);
		}

		$arr = $row->toArray();
		unset($arr["password"]);
		return new Identity($row["id"], $row["action"], $arr);
	}

	private function calculatePassword($inputPassword, $dbStored) {
		$salt = $this->securityActionModel->findSalt();
		if (sizeof($salt) > 0) {
			$calculatedPassword = base64_encode($inputPassword . $salt[0]->salt);
			if ($calculatedPassword == $dbStored) {
				return true;
			}
		}
		return false;
	}

}
