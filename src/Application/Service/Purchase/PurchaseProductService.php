<?php

namespace App\Application\Service\Purchase;

use App\Application\Command\Purchase\PurchaseProductCommand;
use App\Application\Entity\Purchase;
use App\Application\Repository\ProductRepository;
use App\Application\Repository\UserRepository;
use App\Application\Service\AbstractService;
use App\Application\Service\ProductDelivery\DeliverPurchaseService;
use Doctrine\ORM\EntityManagerInterface;

class PurchaseProductService extends AbstractService
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var ProductRepository */
    private $productRepository;

    /** @var UserRepository */
    private $userRepository;

    /** @var DeliverPurchaseService */
    private $deliverPurchaseService;

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

        $user = $this->userRepository->find($command->userId);
        $product = $this->productRepository->get($command->productId);
        $recipientSteamId = $command->recipientSteamId;
        if (!$recipientSteamId) {
            if (!$user) {
                throw new \DomainException('Cannot place anonymous purchase without recipient steam id!');
            }

            $recipientSteamId = $user->getSteamId();
        }

        $purchase = new Purchase(
            [$product],
            $recipientSteamId,
            $user
        );

        $this->em->persist($purchase);
        $this->em->flush();

        //$this->deliverPurchaseService->__invoke($purchase);

        return $purchase;
    }
}
