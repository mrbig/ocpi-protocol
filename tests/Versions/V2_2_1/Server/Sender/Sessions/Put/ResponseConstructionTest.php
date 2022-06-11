<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Sessions\Put;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ChargingPreferencesResponse;
use Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Sessions\Put\SenderSessionPutResponse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Sessions\Put\SenderSessionPutResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function testDataShouldBeNull(): void
    {
        $putResponse = ChargingPreferencesResponse::ACCEPTED();

        // Create response
        $response = new SenderSessionPutResponse($putResponse);
        $responseInterface = $response->getResponseInterface();
        $data = json_decode($responseInterface->getBody()->getContents())->data;
        $this->assertEquals($putResponse, $data);
    }
}
