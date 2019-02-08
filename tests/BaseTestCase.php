<?php

namespace App\Tests;

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
}
