<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tokens\Get;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\TokenType;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tokens\Get\ReceiverTokenGetRequest;
use Tests\Chargemap\OCPI\OcpiTestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tokens\Get\ReceiverTokenGetRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructValidRequest(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface();

        $request = new ReceiverTokenGetRequest($serverRequestInterface, 'EN', 'PID', 'tokenUid', null);
        $this->assertInstanceOf(ReceiverTokenGetRequest::class, $request);
        $this->assertEquals('EN', $request->getCountryCode());
        $this->assertEquals('PID', $request->getPartyId());
        $this->assertEquals('tokenUid', $request->getTokenUid());
        $this->assertEquals(null, $request->getType());

        $request = new ReceiverTokenGetRequest($serverRequestInterface, 'FR', 'FRA', 'otheruid', "RFID");
        $this->assertInstanceOf(ReceiverTokenGetRequest::class, $request);
        $this->assertEquals('FR', $request->getCountryCode());
        $this->assertEquals('FRA', $request->getPartyId());
        $this->assertEquals('otheruid', $request->getTokenUid());
        $this->assertEquals(TokenType::RFID(), $request->getType());
    }
}
