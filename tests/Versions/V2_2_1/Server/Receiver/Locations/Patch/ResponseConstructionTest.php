<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\Patch;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\PartialLocation;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\Patch\ReceiverLocationPatchResponse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\Patch\ReceiverLocationPatchResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function testDataShouldBeNull(): void
    {
        $partialLocation = $this->createMock(PartialLocation::class);

        // Create response
        $response = new ReceiverLocationPatchResponse($partialLocation);
        $responseInterface = $response->getResponseInterface();
        $data = json_decode($responseInterface->getBody()->getContents())->data;
        $this->assertNull($data);
    }
}
