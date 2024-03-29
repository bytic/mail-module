<?php

declare(strict_types=1);

use Nip\Container\Container;

require dirname(__DIR__) . '/vendor/autoload.php';

define('PROJECT_BASE_PATH', __DIR__ . '/..');
define('TEST_BASE_PATH', __DIR__);
define('TEST_FIXTURE_PATH', __DIR__ . \DIRECTORY_SEPARATOR . 'fixtures');

$container = new Container();

$container->set('inflector', new \Nip\Inflector\Inflector());

Container::setInstance($container);
