<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\Get;

use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\Get\OcpiCpoLocationGetRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\LocationRequestGetParams;
use Tests\Chargemap\OCPI\OcpiTestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\Get\OcpiCpoLocationGetRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructWithValidRequest(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface();

        $request = new OcpiCpoLocationGetRequest($serverRequestInterface, new LocationRequestGetParams('locationId'));
        $this->assertInstanceOf(OcpiCpoLocationGetRequest::class, $request);
        $this->assertEquals('locationId', $request->getLocationId());
    }
}
