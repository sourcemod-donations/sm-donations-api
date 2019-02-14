<?php

namespace App\Application\Service\ProductDelivery;

use App\Application\Entity\ProductDelivery;

class PurchaseDeliveryStrategyContext
{
    /** @var PurchaseDeliveryStrategyInterface[] */
    private $strategies = [];

    /**
     * @param array|PurchaseDeliveryStrategyInterface[] $strategies
     */
    public function __construct(array $strategies)
    {
        foreach ($strategies as $strategy) {
            $this->strategies[$strategy->getName()] = $strategy;
        }
    }

    public function handle(ProductDelivery $productDelivery): void
    {
        $properties = $productDelivery->getProductDeliveryConfiguration();
        foreach ($this->strategies as $strategyName => $strategy) {
            if (!isset($properties[$strategyName])) {
                continue;
            }

            $strategy->handle(
                $properties[$strategyName],
                $productDelivery->getServerDeliveryConfiguration(),
                $productDelivery
            );
        }
    }
}
