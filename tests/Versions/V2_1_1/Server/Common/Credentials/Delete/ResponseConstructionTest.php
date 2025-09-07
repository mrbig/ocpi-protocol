<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Common\Credentials\Delete;

use Chargemap\OCPI\Versions\V2_1_1\Server\Common\Credentials\Delete\OcpiCredentialsDeleteResponse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Common\Credentials\Delete\OcpiCredentialsDeleteResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function testDataShouldBeNull(): void
    {
        $response = new OcpiCredentialsDeleteResponse('Message!');
        $responseInterface = $response->getResponseInterface();
        $data = json_decode($responseInterface->getBody()->getContents())->data;
        $this->assertNull($data);
    }
}
