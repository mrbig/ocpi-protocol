<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\Evses\Connectors\Get;

use Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\Evses\Connectors\Get\SenderConnectorGetRequest;
use Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\LocationRequestGetParams;
use InvalidArgumentException;
use Tests\Chargemap\OCPI\OcpiTestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\Evses\Connectors\Get\SenderConnectorGetRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldFailWithoutConnectorId(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface();

        $this->expectException(InvalidArgumentException::class);
        new SenderConnectorGetRequest($serverRequestInterface, new LocationRequestGetParams('locationId', 'evseUid'));
    }

    public function testShouldConstructWithValidRequest(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface();

        $request = new SenderConnectorGetRequest($serverRequestInterface,
            new LocationRequestGetParams('locationId', 'evseUid', 'connectorId'));
        $this->assertInstanceOf(SenderConnectorGetRequest::class, $request);
        $this->assertEquals('connectorId', $request->getConnectorId());
    }
}
