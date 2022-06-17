<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Cdrs\Post;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Cdr;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Cdrs\Post\ReceiverCdrPostResponse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Cdrs\Post\ReceiverCdrPostResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function testDataShouldBeNullAndHeaderIsProvided(): void
    {
        $cdr = $this->createMock(Cdr::class);
        // Create response
        $response = new ReceiverCdrPostResponse($cdr, 'someUrl');
        $responseInterface = $response->getResponseInterface();
        $data = json_decode($responseInterface->getBody()->getContents())->data;
        $this->assertNull($data);
        $this->assertEquals('someUrl', $responseInterface->getHeaderLine('Location'));
    }
}
