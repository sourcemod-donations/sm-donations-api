<?php

namespace App\Application\Entity;

use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Application\Repository\PurchaseRepository")
 */
class Purchase
{
    const PLACED = 0;
    const PAID = 1;

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @var User|null
     * @ORM\OneToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private $buyer;

    /**
     * @var int|null
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $recipientSteamId;

    /**
     * @var Product[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="Product")
     * @ORM\JoinTable(name="purchases_products",
     *      joinColumns={@ORM\JoinColumn(name="purchase_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")}
     *  )
     */
    private $products;

    /**
     * @var DateTimeInterface
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var int
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @param Product[] $products
     */
    public function __construct(array $products, ?User $buyer = null, ?int $recipientSteamId = null)
    {
        $this->buyer = $buyer;
        $this->recipientSteamId = $recipientSteamId;

        if (!$buyer && !$this->recipientSteamId) {
            throw new \DomainException('Cannot place order without both buyer and recipientSteamId');
        }

        $this->products = new ArrayCollection($products);
        $this->price = $this->calculatePrice($products);
        $this->status = self::PLACED;
        $this->createdAt = new DateTimeImmutable();
    }

    public function markAsPaid()
    {
        $this->status = self::PAID;
    }

    /**
     * @param Product[] $products
     */
    private function calculatePrice(array $products): int
    {
        return array_reduce($products, function (int $sum, Product $product) {
            return $sum + $product->getPrice();
        }, 0);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getBuyer(): ?User
    {
        return $this->buyer;
    }

    /**
     * @return Product[]|ArrayCollection
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
}
