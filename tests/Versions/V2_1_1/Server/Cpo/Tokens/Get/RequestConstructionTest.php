<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Tokens\Get;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\TokenType;
use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Tokens\Get\OcpiCpoTokenGetRequest;
use Tests\Chargemap\OCPI\OcpiTestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Tokens\Get\OcpiCpoTokenGetRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructValidRequest(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface();

        $request = new OcpiCpoTokenGetRequest($serverRequestInterface, 'EN', 'PID', 'tokenUid', null);
        $this->assertInstanceOf(OcpiCpoTokenGetRequest::class, $request);
        $this->assertEquals('EN', $request->getCountryCode());
        $this->assertEquals('PID', $request->getPartyId());
        $this->assertEquals('tokenUid', $request->getTokenUid());

        $request = new OcpiCpoTokenGetRequest($serverRequestInterface, 'FR', 'FRA', 'otheruid', "RFID");
        $this->assertInstanceOf(OcpiCpoTokenGetRequest::class, $request);
        $this->assertEquals('FR', $request->getCountryCode());
        $this->assertEquals('FRA', $request->getPartyId());
        $this->assertEquals('otheruid', $request->getTokenUid());
    }
}
