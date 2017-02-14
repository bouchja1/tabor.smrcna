<?php

//###INSERT-LICENSE-HERE###

namespace Models\Security;

use Models\SecurityActionModel;
use Nette\Caching\Cache;
use Nette\Caching\IStorage;

/**
 * SecurityManager
 */
class SecurityManager {
	
	/**
     * @inject
     * @var IStorage
     */
    public $storage;
	
	/**
	 *
	 * @var Cache
	 */
	private $cache;

	/**
	 * @inject
	 * @var SecurityActionModel
	 */
	public $securityActionModel;
	
	public function isActionAllowed($userId,$resourceName,$actionName) {
		$permissions = $this->findAllPermissionsByUserAndResourceAndAction($userId, $resourceName, $actionName);
		return (bool) count($permissions) > 0;
	}
	
	public function getAllowedDefaultLink($userId) {
		if ($this->isActionAllowed($userId, 'Admin:Homepage', 'default')) {
			return ':Admin:Homepage:default';
		} else {
			$permission = $this->findFirstPermissionByUser($userId);
			if ($permission) {
				if ($permission->allowAll) {
					$link = ':' . $permission->resource . ':default';
				} else {
					$link = ':' . $permission->resource . ':' . $permission->action;
				}
				return $link;
			} else {
				return ':Admin:Sign:default';
			}
		}
	}
	
	public function findAllPermissionsByUserAndResourceAndAction($userId,$resourceName,$actionName) {
		$permissions = $this->findAllPermissionsByUser($userId);
		$filteredPermissions = [];
		foreach ($permissions as $permission) {
			if ($permission->resource == $resourceName && ($permission->action == $actionName || $permission->action  == 'ALL')) {
				$filteredPermissions[] = $permission;
			}
		}
		return $filteredPermissions;
	}
	
	public function findFirstPermissionByUser($userId) {
		$permissions = $this->findAllPermissionsByUser($userId);
		if (count($permissions) > 0) {
			return $permissions[0];
		}
		return FALSE;
	}
	
	public function findAllPermissionsByUser($userId) {
		$cacheKey = $this->getUserPrivilegesCacheKey($userId);
		$permissions = $this->getCache()->load($cacheKey);
		if ($permissions === NULL) {
			$permissions = $this->securityActionModel->findPermissionByUser($userId);
			$this->getCache()->save($cacheKey, $permissions);
		}
		return $permissions;
	}
	
	private function getUserPrivilegesCacheKey($userId) {
		return 'userPrivileges-'.$userId;
	}
	
	
	/**
	 * @return Cache
	 */
	private function getCache() {
		if ($this->cache === NULL) {
			$this->cache = new Cache($this->storage, 'security');
		}
		return $this->cache;
	}
	



}
