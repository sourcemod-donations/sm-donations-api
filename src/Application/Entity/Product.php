<?php

namespace App\Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Application\Repository\ProductRepository")
 */
class Product
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
     * @var int
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @var Server[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="Server")
     * @ORM\JoinTable(name="products_servers",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="server_id", referencedColumnName="id")}
     *  )
     */
    private $servers;

    public function __construct()
    {
        $this->servers = new ArrayCollection();
    }

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

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Server[]
     */
    public function getServers(): Collection
    {
        return $this->servers;
    }

    public function addServer(Server $server)
    {
        if (!$this->servers->contains($server)) {
            $this->servers->add($server);
        }
    }

    public function removeServer(Server $server)
    {
        if ($this->servers->contains($server)) {
            $this->servers->removeElement($server);
        }
    }
}
