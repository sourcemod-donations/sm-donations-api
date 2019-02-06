<?php

namespace App\Application\Service\Server;

use App\Application\Command\Server\CreateServerCommand;
use App\Application\Entity\Server;
use App\Application\Service\AbstractService;
use Doctrine\ORM\EntityManagerInterface;

class CreateServerService extends AbstractService
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(
        EntityManagerInterface $em
    ) {
        $this->em = $em;
    }

    public function __invoke(CreateServerCommand $dto): Server
    {
        $this->validCommandOrThrow($dto);

        $server = new Server();
        $server->setName($dto->name);

        $this->em->persist($server);
        $this->em->flush();

        return $server;
    }
}
