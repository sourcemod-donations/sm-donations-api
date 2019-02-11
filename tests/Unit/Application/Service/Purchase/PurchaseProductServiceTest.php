<?php

namespace App\Tests\Unit\Application\Service\Purchase;

use App\Application\Command\Purchase\PurchaseProductCommand;
use App\Application\Entity\Product;
use App\Application\Repository\ProductRepository;
use App\Application\Repository\UserRepository;
use App\Application\Service\Purchase\PurchaseProductService;
use App\Tests\BaseTestCase;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;

class PurchaseProductServiceTest extends BaseTestCase
{
    /** @var EntityManagerInterface|MockObject */
    private $entityManager;

    /** @var ProductRepository|MockObject */
    private $productRepository;

    /** @var UserRepository|MockObject */
    private $userRepository;

    /** @var PurchaseProductService */
    private $service;

    protected function setUp()
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->productRepository = $this->createMock(ProductRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->service = $this->setupService(new PurchaseProductService(
            $this->entityManager,
            $this->productRepository,
            $this->userRepository
        ));
    }

    /**
     * @test
     */
    public function canPlaceAnonymousPurchase()
    {
        $recipientSteamId = 76561197960287930;
        $product = (new Product())->setPrice($this->faker->randomNumber(4));
        $this->productRepository->method('find')->willReturn($product);

        $this->service->__invoke(new PurchaseProductCommand(
            0, // we've mocked productRepo->find, I don't like this, probably should use UUIDs to get id pre-persist
            $recipientSteamId
        ));

        $this->assertTrue(true, 'Order placed anonymously with no exception thrown');
    }

    /**
     * @test
     */
    public function cannotPlaceAnonymousPurchaseWithoutRecipientSteamId()
    {
        $product = (new Product())->setPrice($this->faker->randomNumber(4));
        $this->productRepository->method('find')->willReturn($product);

        $this->expectException(\DomainException::class);

        $this->service->__invoke(new PurchaseProductCommand(
            0
        ));
    }
}
