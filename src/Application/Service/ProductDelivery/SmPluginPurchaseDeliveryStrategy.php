<?php

namespace App\Application\Service\ProductDelivery;

use App\Application\Entity\ProductDelivery;
use App\Application\Entity\SmPluginProductDelivery;
use Doctrine\ORM\EntityManagerInterface;

class SmPluginPurchaseDeliveryStrategy implements PurchaseDeliveryStrategyInterface
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getName(): string
    {
        return 'sm-plugin';
    }

    public function handle(
        array $deliveryConfiguration,
        array $serverConfiguration,
        ProductDelivery $productDelivery
    ): void {
        $smDelivery = new SmPluginProductDelivery(
            $productDelivery,
            $deliveryConfiguration,
            $productDelivery->getRecipientSteamId()
        );

        $this->em->persist($smDelivery);
        $this->em->flush();
    }
}
