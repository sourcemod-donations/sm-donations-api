<?php

namespace App\Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Application\Repository\UserRepository")
 */
class User
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
     * @ORM\Column(type="bigint", unique=true)
     */
    private $steamId;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isAdmin;

    public function __construct(int $steamId)
    {
        $this->name = '';
        $this->isAdmin = false;
        $this->steamId = $steamId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSteamId(): int
    {
        return $this->steamId;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function setAdmin(bool $admin): self
    {
        $this->isAdmin = $admin;

        return $this;
    }
}
