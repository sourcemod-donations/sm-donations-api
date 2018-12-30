<?php

namespace App\Application\Command\Product;

use App\Infrastructure\Contract\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

class EditProductCommand implements RequestDtoInterface
{
    /**
     * @var int
     */
    public $productId;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @var int
     * @Assert\GreaterThanOrEqual(0)
     */
    public $price;
    /**
     * @var int[]
     * @Assert\All({
     *     @Assert\Type("integer")
     * })
     */
    public $servers;

    public function __construct(
        int $productId,
        string $name,
        int $price,
        array $servers = []
    ) {
        $this->productId = $productId;
        $this->name = $name;
        $this->price = $price;
        $this->servers = $servers;
    }
}
