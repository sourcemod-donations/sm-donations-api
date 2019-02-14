<?php

namespace App\Tests\Unit\Application\Service\Delivery;

use App\Application\Entity\ProductDelivery;
use App\Application\Service\ProductDelivery\PurchaseDeliveryStrategyContext;
use App\Tests\BaseTestCase;
use App\Tests\Common\Stub\TestPurchaseDeliveryStrategy;

class PurchaseDeliveryStrategyContextTest extends BaseTestCase
{
    /**
     * @test
     */
    public function resolvesDeliveryConfigurationByStrategyName()
    {
        $strategy = $this->createTestProxy(TestPurchaseDeliveryStrategy::class);
        $context = new PurchaseDeliveryStrategyContext([$strategy]);
        $deliveryConfiguration = [$strategy->getName() => []];
        $delivery = $this->createMock(ProductDelivery::class);
        $delivery
            ->method('getProductDeliveryConfiguration')
            ->willReturn($deliveryConfiguration);

        $strategy
            ->expects($this->once())
            ->method('handle');

        $context->handle($delivery);
    }
}
