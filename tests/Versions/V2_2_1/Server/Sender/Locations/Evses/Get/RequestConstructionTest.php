<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\Evses\Get;

use Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\Evses\Get\SenderEvseGetRequest;
use Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\LocationRequestGetParams;
use InvalidArgumentException;
use Tests\Chargemap\OCPI\OcpiTestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\Evses\Get\SenderEvseGetRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldFailWithoutEvseUid(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface();

        $this->expectException(InvalidArgumentException::class);
        new SenderEvseGetRequest($serverRequestInterface, new LocationRequestGetParams('locationId'));
    }

    public function testShouldConstructWithValidRequest(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface();

        $request = new SenderEvseGetRequest($serverRequestInterface, new LocationRequestGetParams('locationId', 'evseUid'));
        $this->assertInstanceOf(SenderEvseGetRequest::class, $request);
        $this->assertEquals('evseUid', $request->getEvseUid());
    }
}
