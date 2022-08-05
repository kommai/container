<?php

declare(strict_types=1);

use Kommai\Container;

class BaseContainer extends Container implements ArrayAccess
{
    public function __construct()
    {
        $this[ExampleService::class] = function () {
            return new ExampleService([
                'container' => $this::class,
            ]);
        };
        $this[ExampleServiceUser::class] = function () {
            return new ExampleServiceUser(
                $this[ExampleService::class],
            );
        };
    }
}
