<?php

namespace App\Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Application\Repository\ServerRepository")
 */
class Server
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var array
     * @ORM\Column(type="json_array")
     */
    private $deliveryConfiguration;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDeliveryConfiguration(): array
    {
        return $this->deliveryConfiguration;
    }

    public function setDeliveryConfiguration(array $deliveryConfiguration): self
    {
        $this->deliveryConfiguration = $deliveryConfiguration;

        return $this;
    }
}
