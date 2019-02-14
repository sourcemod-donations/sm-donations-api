<?php

namespace App\Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Application\Repository\ProductDeliveryRepository")
 */
class ProductDelivery
{
    const NEW = 0;
    const PROCESSING = 1;
    const PROCESSED = 2;

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;

    /**
     * @var Server
     * @ORM\ManyToOne(targetEntity="Server")
     * @ORM\JoinColumn(name="server_id", referencedColumnName="id")
     */
    private $server;

    /**
     * @var int
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @var array
     * @ORM\Column(type="json")
     */
    private $metadata;

    /**
     * @var array
     * @ORM\Column(type="json_array")
     */
    private $productDeliveryConfiguration;

    /**
     * @var array
     * @ORM\Column(type="json_array")
     */
    private $serverDeliveryConfiguration;

    /**
     * @var int
     * @ORM\Column(type="bigint")
     */
    private $recipientSteamId;

    public function __construct(
        Product $product,
        Server $server,
        int $recipientSteamId
    ) {
        $this->product = $product;
        $this->server = $server;
        $this->metadata = [];
        $this->status = self::NEW;
        $this->productDeliveryConfiguration = $product->getDeliveryConfiguration();
        $this->serverDeliveryConfiguration = $server->getDeliveryConfiguration();
        $this->recipientSteamId = $recipientSteamId;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }

    public function setMetadata(array $metadata): self
    {
        $this->metadata = $metadata;

        return $this;
    }

    public function setProcessing()
    {
        $this->status = self::PROCESSING;
    }

    public function setProcessed()
    {
        $this->status = self::PROCESSED;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getProductDeliveryConfiguration(): array
    {
        return $this->productDeliveryConfiguration;
    }

    public function getServerDeliveryConfiguration(): array
    {
        return $this->serverDeliveryConfiguration;
    }

    public function getRecipientSteamId(): int
    {
        return $this->recipientSteamId;
    }
}
