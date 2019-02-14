<?php

namespace App\Tests\Unit\Application\Service\Delivery;

use App\Application\Repository\ProductRepository;
use App\Application\Repository\UserRepository;
use App\Application\Service\ProductDelivery\DeliverPurchaseService;
use App\Tests\BaseTestCase;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;

class DeliverPurchaseServiceTest extends BaseTestCase
{
    /** @var DeliverPurchaseService|MockObject */
    private $service;

    /** @var EntityManagerInterface|MockObject */
    private $em;

    /** @var ProductRepository|MockObject */
    private $productRepository;

    /** @var UserRepository|MockObject */
    private $userRepository;


    protected function setUp()
    {
        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->productRepository = $this->createMock(ProductRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);

        $this->service = new DeliverPurchaseService(
            $this->em,
            $this->productRepository,
            $this->userRepository
        );
    }

    /**
     * @test
     */
    public function registeredDeliveryStrategiesAreRun()
    {
        //$this->service->__invoke();
    }
}
