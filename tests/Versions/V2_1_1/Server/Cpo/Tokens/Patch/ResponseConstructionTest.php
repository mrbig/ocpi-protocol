<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Tokens\Patch;

use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Tokens\Patch\OcpiCpoTokenPatchResponse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Tokens\Patch\OcpiCpoTokenPatchResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function testDataShouldBeNull(): void
    {

        // Create response
        $response = new OcpiCpoTokenPatchResponse();
        $responseInterface = $response->getResponseInterface();
        $data = json_decode($responseInterface->getBody()->getContents())->data;
        $this->assertNull($data);
    }
}
