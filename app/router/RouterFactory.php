<?php

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;
use Nette\Utils\Strings;


final class RouterFactory
{

    private $router;
    private $isSecured;

	/**
	 * @return Nette\Application\IRouter
	 */
	public function createRouter()
	{
        if (isset($_SERVER['SERVER_PORT']) AND $_SERVER['SERVER_PORT'] == 443) {
            $this->isSecured = TRUE;
        }

        // Setup router
        $this->router = new RouteList();

        $this->createAdminModuleRouter();
        $this->createFrontModuleRouter();

        return $this->router;

        /*
		$router = new RouteList;

        // Setup router
        $router[] = $frontRouter = new RouteList('Front');

        $frontRouter[] = new Route('<presenter=Homepage>/<action=default>', array(
            'presenter' => array(
                Route::FILTER_TABLE => array(
                    'kontakt' => 'Contact',
                    'historie' => 'About',
                    'lokalita' => 'Location',
                    'tabor' => 'Camp'
                )),
            'action' => 'default',
            'title' => array(
                Route::VALUE => NULL,
                Route::FILTER_IN => function($url) {
                    return Strings::webalize($url);
                },
                Route::FILTER_OUT => function($url) {
                    return Strings::webalize($url);
                }
            ),
            'id' => NULL
                ), NULL);

        $router[] = $adminRouter = new RouteList('Admin');

        $adminRouter[] = new Route('admin/<presenter=Homepage>/<action=default>', array(
            'presenter' => 'Homepage',
            'action' => 'default',
            'id' => NULL,
                ), NULL);

        $router[] = new Route('index.php', 'Homepage:default', Route::ONE_WAY);
        $router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');

        return $router;
        */
	}

    private function createAdminModuleRouter() {
        $this->router[] = $adminRouter = new RouteList('Admin');

        $adminRouter[] = new Route('administration/<presenter>[/<action=default>][/<id>]', array(
            'presenter' => 'Homepage',
            'action' => 'default',
            'id' => NULL,
        ), $this->isSecured ? Route::SECURED : NULL);
    }

    private function createFrontModuleRouter() {
        $this->router[] = $frontRouter = new RouteList('Front');

        $frontRouter[] = new Route('<presenter=Homepage>/<action=default>/<id>/', array(
            'presenter' => array(
                Route::FILTER_TABLE => array(
                    'kontakt' => 'Contact',
                    'historie' => 'About',
                    'lokalita' => 'Location',
                    'tabor' => 'Camp'
                )),
            'action' => 'default',
            'id' => NULL,
            'title' => array(
                Route::VALUE => NULL,
                Route::FILTER_IN => function($url) {
                    return Strings::webalize($url);
                },
                Route::FILTER_OUT => function($url) {
                    return Strings::webalize($url);
                }
            ),
        ), $this->isSecured ? Route::SECURED : NULL);
    }

}
