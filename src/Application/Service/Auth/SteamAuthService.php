<?php

namespace App\Application\Service\Auth;

use App\Application\Exception\Auth\AuthFailedException;
use App\Application\Service\AbstractService;
use SteamAuth\SteamOpenId;

class SteamAuthService extends AbstractService
{
    /** @var SteamOpenId */
    private $steamOpenId;

    public function __construct(SteamOpenId $steamOpenId)
    {
        $this->steamOpenId = $steamOpenId;
    }

    public function getRedirectUrl(): string
    {
        return $this->steamOpenId->getRedirectUrl();
    }

    /**
     * @throws AuthFailedException
     */
    public function verify(array $requestParameters): string
    {
        $steamid = $this->steamOpenId->verifyAssertion($requestParameters);
        if ($steamid === false) {
            throw new AuthFailedException();
        }

        return $steamid;
    }
}
