<?php

namespace App\Application\Command\Purchase;

class PurchaseProductCommand
{
    /**
     * @var int
     */
    public $productId;

    /**
     * @var int|null
     */
    public $recipientSteamId;

    /**
     * @var int|null
     */
    public $userId;

    public function __construct(
        int $productId,
        ?int $recipientSteamId = null,
        ?int $userId = null
    ) {
        $this->productId = $productId;
        $this->recipientSteamId = $recipientSteamId;
        $this->userId = $userId;
    }
}
