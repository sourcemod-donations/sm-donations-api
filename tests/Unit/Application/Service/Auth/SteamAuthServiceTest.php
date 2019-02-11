<?php

namespace App\Tests\Unit\Application\Service\Auth;

use App\Application\Exception\Auth\AuthFailedException;
use App\Application\Service\Auth\SteamAuthService;
use App\Tests\BaseTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use SteamAuth\SteamOpenId;

class SteamAuthServiceTest extends BaseTestCase
{
    /** @var SteamAuthService */
    private $service;

    /** @var MockObject|SteamOpenId */
    private $openIdMock;

    protected function setUp()
    {
        $this->openIdMock = $this->createMock(SteamOpenId::class);
        $this->service = new SteamAuthService($this->openIdMock);
    }

    /**
     * @test
     */
    public function getRedirectUrl_shouldReturnValidUrl()
    {
        $this->openIdMock
            ->method('getRedirectUrl')
            ->willReturn($this->faker->url);

        $url = $this->service->getRedirectUrl();

        $isUrl = filter_var($url, FILTER_VALIDATE_URL) !== false;
        $this->assertTrue($isUrl, 'getRedirectUrl didn\'t return a valid url');
    }

    /**
     * @test
     */
    public function verify_shouldReturnSteamIdOnValidResponse()
    {
        $steamId = '76561197996874997';
        $this->openIdMock
            ->method('verifyAssertion')
            ->willReturn($steamId);

        $result = $this->service->verify([]);

        $this->assertSame($steamId, $result);
    }

    /**
     * @test
     */
    public function verify_shouldThrowOnInvalidResponse()
    {
        $this->openIdMock
            ->method('verifyAssertion')
            ->willReturn(false);

        $this->expectException(AuthFailedException::class);

        $this->service->verify([]);
    }
}
