<?php

namespace App\Application\Service\ProductDelivery;

use App\Application\Entity\ProductDelivery;
use App\Application\Entity\Purchase;
use App\Application\Repository\ProductRepository;
use App\Application\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeliverPurchaseService
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

    public function __invoke(Purchase $purchase): Purchase
    {
        $products = $purchase->getProducts();
        foreach ($products as $product) {
            foreach ($product->getServers() as $server) {
                $delivery = new ProductDelivery(
                    $product,
                    $server,
                    $purchase->getRecipientSteamId()
                );

                $this->em->persist($delivery);
                $this->em->flush();
            }
        }

        return $purchase;
    }
}
