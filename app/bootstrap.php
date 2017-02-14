<?php

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

//$configurator->setDebugMode(FALSE); // enable for your remote IP
$configurator->enableDebugger(__DIR__ . '/../log');

$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');

if (apache_getenv("APPLICATION_ENV") === 'production') {
	$configurator->addConfig(__DIR__ . '/config/config.production.neon');
	$configurator->setDebugMode(false);
	\Tracy\Debugger::$productionMode = true;
} else {
	$configurator->addConfig(__DIR__ . '/config/config.local.neon');
	$configurator->setDebugMode(true);
	\Tracy\Debugger::$productionMode = false;
}

$container = $configurator->createContainer();

return $container;
