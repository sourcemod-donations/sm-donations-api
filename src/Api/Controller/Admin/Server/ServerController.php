<?php

namespace App\Api\Controller\Admin\Server;

use App\Application\Command\Server\CreateServerCommand;
use App\Application\Service\Server\CreateServerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServerController extends AbstractController
{
    /**
     * @var CreateServerService
     */
    private $createServerService;

    public function __construct(
        CreateServerService $createServerService
    ) {
        $this->createServerService = $createServerService;
    }

    /**
     * @Route("/servers", methods={"POST"})
     */
    public function add(CreateServerCommand $command)
    {
        $server = $this->createServerService->__invoke($command);

        return new JsonResponse($server->getId(), Response::HTTP_CREATED);
    }
}
