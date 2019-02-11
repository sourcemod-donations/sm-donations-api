<?php

namespace App\Application\Service\Purchase;

use App\Application\Command\Purchase\PurchaseProductCommand;
use App\Application\Entity\Purchase;
use App\Application\Repository\ProductRepository;
use App\Application\Repository\UserRepository;
use App\Application\Service\AbstractService;
use Doctrine\ORM\EntityManagerInterface;

class PurchaseProductService extends AbstractService
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var ProductRepository */
    private $productRepository;

    /** @var UserRepository */
    private $userRepository;

    public function __construct(
        EntityManagerInterface $em,
        ProductRepository $productRepository,
        UserRepository $userRepository
    ) {
        $this->em = $em;
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    public function __invoke(PurchaseProductCommand $command): Purchase
    {
        $this->validCommandOrThrow($command);

        $product = $this->productRepository->get($command->productId);
        $purchase = new Purchase(
            [$product],
            $this->userRepository->find($command->userId),
            $command->recipientSteamId
        );

        $this->em->persist($purchase);
        $this->em->flush();

        return $purchase;
    }
}
