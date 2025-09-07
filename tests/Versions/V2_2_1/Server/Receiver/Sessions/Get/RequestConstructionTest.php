<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Sessions\Get;

use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Sessions\Get\ReceiverSessionGetRequest;
use Tests\Chargemap\OCPI\OcpiTestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Sessions\Get\ReceiverSessionGetRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructValidRequest(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface();

        $request = new ReceiverSessionGetRequest($serverRequestInterface, 'EN', 'PID', 'sessionId');
        $this->assertInstanceOf(ReceiverSessionGetRequest::class, $request);
        $this->assertEquals('EN', $request->getCountryCode());
        $this->assertEquals('PID', $request->getPartyId());
        $this->assertEquals('sessionId', $request->getSessionId());
    }
}
