<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tokens\Patch;

use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tokens\Patch\ReceiverTokenPatchResponse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tokens\Patch\ReceiverTokenPatchResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function testDataShouldBeNull(): void
    {

        // Create response
        $response = new ReceiverTokenPatchResponse();
        $responseInterface = $response->getResponseInterface();
        $data = json_decode($responseInterface->getBody()->getContents())->data;
        $this->assertNull($data);
    }
}
