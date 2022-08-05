<?php

declare(strict_types=1);

use Kommai\TestKit\Proxy;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/classes.php';
require_once __DIR__ . '/container-base.php';

$container = new BaseContainer();

$service = $container[ExampleService::class];
var_dump($service);