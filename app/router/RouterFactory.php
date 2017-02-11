<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;
use Nette\Utils\Strings;


class RouterFactory
{

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;

        // Setup router
        $router[] = $frontRouter = new RouteList('Front');

        $frontRouter[] = new Route('<presenter=Homepage>/<action=default>', array(
            'presenter' => array(
                Route::FILTER_TABLE => array(
                    'kontakt' => 'Contact',
                    'filmy' => 'Film',
                    'pravidla-souteze' => 'Rules'
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

        $adminRouter[] = new Route('administration/<presenter=Homepage>/<action=default>/<id>', array(
            'presenter' => 'Homepage',
            'action' => 'default',
            'id' => NULL,
                ), NULL);

        $router[] = new Route('index.php', 'Homepage:default', Route::ONE_WAY);
        $router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');

        return $router;
	}

}
