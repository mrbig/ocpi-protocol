<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\Get;

use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\Get\ReceiverLocationGetRequest;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\LocationRequestParams;
use Tests\Chargemap\OCPI\OcpiTestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\Get\ReceiverLocationGetRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructWithValidRequest(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface();

        $request = new ReceiverLocationGetRequest($serverRequestInterface, new LocationRequestParams('EN', 'PID', 'locationId'));
        $this->assertInstanceOf(ReceiverLocationGetRequest::class, $request);
        $this->assertEquals('locationId', $request->getLocationId());
    }
}
