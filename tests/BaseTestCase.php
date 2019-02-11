<?php

namespace App\Tests;

use App\Application\Service\AbstractService;
use App\Tests\Common\AlwaysValidCommandValidator;
use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    /** @var \Faker\Generator */
    protected $faker;

    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->faker = \Faker\Factory::create();
    }

    protected function setupService(AbstractService $service): AbstractService
    {
        $service->setCommandValidator(new AlwaysValidCommandValidator());

        return $service;
    }
}
