<?php

namespace App\Application\Service\ProductDelivery;

use App\Application\Entity\ProductDelivery;

interface PurchaseDeliveryStrategyInterface
{
    public function getName(): string;

    public function handle(
        array $deliveryConfiguration,
        array $serverConfiguration,
        ProductDelivery $productDelivery
    ): void;
}
