<?php

//###INSERT-LICENSE-HERE###

namespace App\FrontModule\Presenters;

use App\Presenters\BasePresenter;
use Nette\Application\Responses\TextResponse;
use Nette\ArrayHash;
use Nette\Caching\Cache;
use Nette\Caching\IStorage;
use Nette\Http\Session;

abstract class ModuleBasePresenter extends BasePresenter {

	private $cacheKey;
	private $cached = FALSE;
	private $turnOffCache = TRUE;

	/**
	 * @var Session
	 */
	private $session;

	/**
	 * @var IStorage
	 */
	private $cacheStorage;

	protected function startup() {
		parent::startup();
		if (!$this->turnOffCache) {
			$this->displayPageIfIsCached();
		}
	}

	/**
	 * @param Session $session
	 */
	public final function injectSession(Session $session) {
		$this->session = $session;
	}

	/**
	 * @param IStorage $cacheStorage
	 */
	public final function injectCacheStorage(IStorage $cacheStorage) {
		$this->cacheStorage = $cacheStorage;
	}

	private function displayPageIfIsCached() {
		if (!$this->isAjax() && !$this->isSignal()) {
			$cache = new Cache($this->cacheStorage, 'app/out');

			$this->cacheKey = $this->generateCacheKey();

			// ověření, zda je položka v keši
			$value = $cache->load($this->cacheKey);
			if ($value !== NULL) {
				echo $value;
				$this->cached = TRUE;
				$this->terminate();
			}
		}
	}

	private function generateCacheKey() {
		$cacheName = $this->getName() . ':' . $this->getAction();
		$cacheName .= '-' . $this->createParamsHash();

		return $cacheName;
	}

	protected function createParamsHash() {
		return sha1($this->createStringFromParams() . $this->createStringFromSessionParams());
	}

	protected function createStringFromParams() {
		$cacheName = '';
		foreach ($this->getParameters() as $key => $value) {
			$cacheName .= $key . ':' . $value;
		}
		return $cacheName;
	}

	private function createStringFromSessionParams() {
		$cacheName = '';
		$sessionNames = array();
		foreach ($sessionNames as $name) {
			$cacheName .= $this->getStringFromSessionSection($name);
		}
		return $cacheName;
	}

	private function getStringFromSessionSection($sectionName) {
		$cacheName = '';
		if ($this->session->hasSection($sectionName)) {
			$section = $this->session->getSection($sectionName);
			$cacheName .= $this->convertToString($section);
		}
		return $cacheName;
	}

	private function convertToString($array) {
		$output = '';
		foreach ($array as $key => $value) {
			if ($value instanceof ArrayHash) {
				$output .= $this->convertToString($value);
			} else {
				$output .= $key . ':' . $value;
			}
		}
		return $output;
	}

	protected function beforeRender() {
		parent::beforeRender();
	}

	public function shutdown($response) {
		if (!$this->turnOffCache) {
			$this->savePageToCache($response);
		}
	}

	private function savePageToCache($response) {
		if (!$this->isAjax() && !$this->isSignal() && $response instanceof TextResponse) {
			if ($this->cacheKey && !$this->cached) {
				$content = $this->template->__toString();
				if ($content) {
					echo $content;
					$cache = new Cache($this->cacheStorage, 'app/out');
					$config = array("expire" => 300);
					$cache->save($this->cacheKey, $content, $config);
				}
			} else {
				parent::shutdown($response);
			}
			die;
		}
	}

}
