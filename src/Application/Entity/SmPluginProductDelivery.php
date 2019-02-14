<?php

namespace App\Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Application\Repository\SmPluginProductDeliveryRepository")
 */
class SmPluginProductDelivery
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var ProductDelivery
     * @ORM\ManyToOne(targetEntity="ProductDelivery")
     * @ORM\JoinColumn(name="productdelivery_id", referencedColumnName="id")
     */
    private $productDelivery;

    /**
     * @var array
     * @ORM\Column(type="json_array")
     */
    private $deliveryConfiguration;

    /**
     * @var int
     * @ORM\Column(type="bigint")
     */
    private $steamId;

    public function __construct(
        ProductDelivery $productDelivery,
        array $deliveryConfiguration,
        int $steamId
    ) {
        $this->productDelivery = $productDelivery;
        $this->deliveryConfiguration = $deliveryConfiguration;
        $this->steamId = $steamId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductDelivery(): ProductDelivery
    {
        return $this->productDelivery;
    }

    public function getSteamId(): int
    {
        return $this->steamId;
    }

    public function getDeliveryConfiguration(): array
    {
        return $this->deliveryConfiguration;
    }
}
