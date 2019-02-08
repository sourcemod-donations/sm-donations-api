<?php

namespace App\Application\Security;

use App\Application\Service\Auth\AuthTokenService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class TokenGuardAuthenticator extends AbstractGuardAuthenticator
{
    /** @var AuthTokenService */
    private $tokenService;

    public function __construct(AuthTokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new JsonResponse([
            'message' => 'Authentication token missing'
        ], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * {@inheritdoc}
     */
    public function supports(Request $request)
    {
        return $request->headers->has('Authorization');
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials(Request $request)
    {
        @list($token) = sscanf(
            $request->headers->get('Authorization'),
            'Bearer %s'
        );

        return $token;
    }

    /**
     * {@inheritdoc}
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $user = $this->tokenService->verify($credentials);

        return new SecurityUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse([
            'message' => 'Invalid authentication token'
        ], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        // intentionally empty
    }

    /**
     * {@inheritdoc}
     */
    public function supportsRememberMe()
    {
        return false;
    }
}
