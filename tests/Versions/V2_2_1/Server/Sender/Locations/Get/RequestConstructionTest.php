<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\Get;

use Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\Get\SenderLocationGetRequest;
use Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\LocationRequestGetParams;
use Tests\Chargemap\OCPI\OcpiTestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\Get\SenderLocationGetRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructWithValidRequest(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface();

        $request = new SenderLocationGetRequest($serverRequestInterface, new LocationRequestGetParams('locationId'));
        $this->assertInstanceOf(SenderLocationGetRequest::class, $request);
        $this->assertEquals('locationId', $request->getLocationId());
    }
}
