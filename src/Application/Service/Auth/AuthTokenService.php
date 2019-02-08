<?php

namespace App\Application\Service\Auth;

use App\Application\Entity\User;
use App\Application\Entity\UserToken;
use App\Application\Exception\Auth\InvalidAuthTokenException;
use App\Application\Repository\UserTokenRepository;
use Doctrine\ORM\EntityManagerInterface;

class AuthTokenService
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var UserTokenRepository */
    private $tokenRepository;

    public function __construct(EntityManagerInterface $em, UserTokenRepository $tokenRepository)
    {
        $this->em = $em;
        $this->tokenRepository = $tokenRepository;
    }

    public function generate(User $user): string
    {
        $token = bin2hex(random_bytes(96));
        $tokenEntity = new UserToken($user, $token);

        $this->em->persist($tokenEntity);
        $this->em->flush();

        return $this->serialize($tokenEntity);
    }

    /**
     * @throws InvalidAuthTokenException
     */
    public function verify(string $serializedToken): User
    {
        @list($id, $token) = explode(':', $serializedToken);
        $tokenEntity = $this->tokenRepository->find($id);
        if (!$tokenEntity) {
            throw new InvalidAuthTokenException();
        }

        $valid = hash_equals($tokenEntity->getToken(), $token);
        if (!$valid) {
            throw new InvalidAuthTokenException();
        }

        return $tokenEntity->getUser();
    }

    private function serialize(UserToken $token): string
    {
        return $token->getId() . ':' . $token->getToken();
    }
}
