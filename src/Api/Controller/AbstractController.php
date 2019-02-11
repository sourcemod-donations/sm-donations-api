<?php

namespace App\Api\Controller;

use App\Application\Entity\User;
use App\Application\Security\SecurityUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyAbstractController;

class AbstractController extends SymfonyAbstractController
{
    protected function getUser(): User
    {
        /** @var SecurityUser $securityUser */
        $securityUser = parent::getUser();

        return $securityUser ? $securityUser->getUser() : null;
    }

    protected function getUserId(): int
    {
        $user = $this->getUser();

        return $user ? $user->getId() : null;
    }
}
