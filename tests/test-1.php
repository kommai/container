<?php

declare(strict_types=1);

use Kommai\Container;
use Kommai\TestKit\Proxy;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/classes.php';

$definitions = [
    ExampleService::class => function () {
        return new ExampleService([
            'some_option' => 123,
        ]);
    },
    ExampleServiceUser::class => function ($c) {
        return new ExampleServiceUser($c[ExampleService::class]);
    },
];

$definitionsAlternative = [
    ExampleService::class => function () {
        return new ExampleServiceAlternative();
    },
];

//$container = new Container($definitions);
$container = new Container(array_merge($definitions, $definitionsAlternative));
$user = $container[ExampleServiceUser::class];
var_dump($user, $user === $container[ExampleServiceUser::class]);

$containerProxy = new Proxy($container);
//var_dump($containerProxy->definitions);
var_dump($containerProxy->cache);
