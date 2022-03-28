<?php

declare(strict_types=1);

class ExampleService
{
    protected array $options;

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }
}

class ExampleServiceAlternative extends ExampleService
{
    public function __construct(array $options = [])
    {
        parent::__construct($options);
        $this->options['alternative'] = true;
    }
}

class ExampleServiceUser
{
    public $value;
    private ExampleService $service;

    public function __construct(ExampleService $service)
    {
        $this->service = $service;
    }
}
