<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Emsp\Sessions\Patch;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\PartialSession;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Sessions\Patch\ReceiverSessionPatchResponse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Sessions\Patch\ReceiverSessionPatchResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function testDataShouldBeNull(): void
    {
        $session = $this->createMock(PartialSession::class);

        // Create response
        $response = new ReceiverSessionPatchResponse($session);
        $responseInterface = $response->getResponseInterface();
        $data = json_decode($responseInterface->getBody()->getContents())->data;
        $this->assertNull($data);
    }
}
