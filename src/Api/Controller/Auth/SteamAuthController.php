<?php

namespace App\Api\Controller\Auth;

use App\Application\Command\User\CreateUserCommand;
use App\Application\Service\Auth\AuthTokenService;
use App\Application\Service\Auth\SteamAuthService;
use App\Application\Service\User\CreateUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SteamAuthController extends AbstractController
{
    /** @var SteamAuthService */
    private $authService;

    /** @var CreateUserService */
    private $createUserService;

    /** @var AuthTokenService */
    private $authTokenService;

    public function __construct(
        SteamAuthService $authService,
        CreateUserService $createUserService,
        AuthTokenService $authTokenService
    ) {
        $this->authService = $authService;
        $this->createUserService = $createUserService;
        $this->authTokenService = $authTokenService;
    }

    /**
     * @Route("/auth/steam/redirect", methods={"GET"})
     */
    public function providerRedirect()
    {
        return $this->redirect($this->authService->getRedirectUrl());
    }

    /**
     * @Route("/auth/steam/verify", methods={"GET"})
     */
    public function providerVerify(Request $request)
    {
        $steamId = $this->authService->verify($request->request->all());
        $command = new CreateUserCommand((int)$steamId);
        $user = $this->createUserService->__invoke($command);
        $token = $this->authTokenService->generate($user);

        return new JsonResponse([
            'token' => $token,
        ]);
    }
}
