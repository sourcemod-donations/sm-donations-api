<?php

namespace App\Application\Security;

use App\Application\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Symfony Security component requires us to extend UserInterface
 * which contains non-sense methods in context of token auth
 *
 * This is a way of decoupling from the Security component.
 */
class SecurityUser implements UserInterface
{
    /** @var User */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return $this->user->isAdmin() ? ['ROLE_ADMIN'] : ['ROLE_USER'];
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return $this->user->getSteamId();
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        // intentionally empty
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        // intentionally empty
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        // intentionally empty
    }
}
