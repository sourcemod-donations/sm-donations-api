<?php

namespace App\Application\Factory;

use SteamAuth\SteamOpenId;

class SteamOpenIdFactory
{
    public static function create(): SteamOpenId
    {
        $returnTo = getenv('APP_STEAM_REDIRECT_URL');

        return new SteamOpenId([
            'realm' => $returnTo,
            'return_to' => $returnTo,
        ]);
    }
}
