<?php

namespace App\Application\Service\User;

use App\Application\Command\User\CreateUserCommand;
use App\Application\Entity\User;
use App\Application\Repository\UserRepository;
use App\Application\Service\AbstractService;
use Doctrine\ORM\EntityManagerInterface;

class CreateUserService extends AbstractService
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var UserRepository */
    private $userRepository;

    public function __construct(
        EntityManagerInterface $em,
        UserRepository $userRepository
    ) {
        $this->em = $em;
        $this->userRepository = $userRepository;
    }

    public function __invoke(CreateUserCommand $command): User
    {
        $this->validCommandOrThrow($command);

        $steamId = $command->steamId;
        $user = $this->userRepository->findBySteamId($steamId) ?? new User($steamId);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
