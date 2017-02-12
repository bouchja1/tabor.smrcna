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
	

	public function findAllResourcesWithActions() {
		$resources = $this->securityResourceModel->findAll()->orderBy('title')->fetchAssoc('id');
		$actions = $this->securityActionModel->findAll()->orderBy('allowAll DESC, title')->fetchAll();
		foreach ($actions as $action) {
			if (!key_exists('actions', $resources[$action->securityResource_id])) {
				$resources[$action->securityResource_id]->actions = array();
			}
			$resources[$action->securityResource_id]->actions[$action->id] = $action;
		}
		return $resources;
	}
	
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
	
	public function hasUserPermissionToArticle($userId,$articleId) {
		$article = $this->articleModel->getById($articleId);
		$articles = $this->allowedArticles($userId);
		return $this->isArticleChildOfArticles($article, $articles);
	}
	
	public function allowedArticles($userId) {
		return $this->securityUserArticlePermissionModel->getDatabase()
				->select("*")
				->from(SecurityUserArticlePermissionModel::TABLE. " permission")
				->join(ArticleModel::TABLE. " article" )->on("article.id = permission.article_id")
				->where("permission.user_id = %i", $userId)
				->fetchAll();
	}
	
	public function isArticleChildOfArticles($article,$articles) {
		return $this->articleModel->isArticleChildOfArticles($article, $articles);
	}
	
	public function initializePrivileges($userId) {
		$this->securityActionModel->getDatabase()->query(
				"REPLACE INTO securityUserAction (user_id, securityAction_id ) "
				. "SELECT %i AS user_id, id AS securityAction_id FROM securityAction WHERE allowAll = %b;",$userId,TRUE);
		
	}
	
	public function replaceAllUserPrivileges($userId, $values) {
		$this->securityUserActionModel->replaceAllUserPrivileges($userId, $values);
		$key = $this->getUserPrivilegesCacheKey($userId);
		$this->getCache()->remove($key);
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
