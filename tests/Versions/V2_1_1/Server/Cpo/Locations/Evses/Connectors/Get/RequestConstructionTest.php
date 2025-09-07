<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\Evses\Connectors\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\Evses\Connectors\Get\OcpiCpoConnectorGetRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\LocationRequestGetParams;
use InvalidArgumentException;
use Tests\Chargemap\OCPI\OcpiTestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\Evses\Connectors\Get\OcpiCpoConnectorGetRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldFailWithoutConnectorId(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface();

        $this->expectException(InvalidArgumentException::class);
        new OcpiCpoConnectorGetRequest($serverRequestInterface, new LocationRequestGetParams('locationId', 'evseUid'));
    }

    public function testShouldConstructWithValidRequest(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface();

        $request = new OcpiCpoConnectorGetRequest($serverRequestInterface,
            new LocationRequestGetParams('locationId', 'evseUid', 'connectorId'));
        $this->assertInstanceOf(OcpiCpoConnectorGetRequest::class, $request);
        $this->assertEquals('connectorId', $request->getConnectorId());
    }
}
