<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\Evses\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\Evses\Get\OcpiCpoEvseGetRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\LocationRequestGetParams;
use InvalidArgumentException;
use Tests\Chargemap\OCPI\OcpiTestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\Evses\Get\OcpiCpoEvseGetRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldFailWithoutEvseUid(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface();

        $this->expectException(InvalidArgumentException::class);
        new OcpiCpoEvseGetRequest($serverRequestInterface, new LocationRequestGetParams('locationId'));
    }

    public function testShouldConstructWithValidRequest(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface();

        $request = new OcpiCpoEvseGetRequest($serverRequestInterface, new LocationRequestGetParams('locationId', 'evseUid'));
        $this->assertInstanceOf(OcpiCpoEvseGetRequest::class, $request);
        $this->assertEquals('evseUid', $request->getEvseUid());
    }
}
