<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Cdrs\Get;

use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Cdrs\Get\ReceiverCdrGetRequest;
use Tests\Chargemap\OCPI\OcpiTestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Cdrs\Get\OcpiEmspCdrGetRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function testShouldConstructWithValidRequest(): void
    {
        $serverRequestInterface = $this->createServerRequestInterface();

        $request = new ReceiverCdrGetRequest($serverRequestInterface, '1234');
        $this->assertInstanceOf(ReceiverCdrGetRequest::class, $request);
        $this->assertEquals('1234', $request->getCdrId());
    }
}
