<?php

namespace App\Tests\Common\Stub;

use App\Application\Entity\ProductDelivery;
use App\Application\Service\ProductDelivery\PurchaseDeliveryStrategyInterface;

class TestPurchaseDeliveryStrategy implements PurchaseDeliveryStrategyInterface
{
    public function getName(): string
    {
        return 'test';
    }

    public function handle(
        array $deliveryConfiguration,
        array $serverConfiguration,
        ProductDelivery $productDelivery
    ): void {
        // intentionally left empty
    }
}
