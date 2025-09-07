<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\Put;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Location;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\Put\ReceiverLocationPutResponse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\Put\ReceiverLocationPutResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function testDataShouldBeNull(): void
    {
        $location = $this->createMock(Location::class);

        // Create response
        $response = new ReceiverLocationPutResponse($location);
        $responseInterface = $response->getResponseInterface();
        $data = json_decode($responseInterface->getBody()->getContents())->data;
        $this->assertNull($data);
    }
}
