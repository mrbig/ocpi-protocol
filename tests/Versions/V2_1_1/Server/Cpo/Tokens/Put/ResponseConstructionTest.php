<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Tokens\Put;


use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Token;
use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Tokens\Put\OcpiCpoTokenPutResponse;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Cpo\Tokens\Put\OcpiCpoTokenPutResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function testDataShouldBeNull(): void
    {
        $token = $this->createMock(Token::class);

        // Create response
        $response = new OcpiCpoTokenPutResponse();
        $responseInterface = $response->getResponseInterface();
        $data = json_decode($responseInterface->getBody()->getContents())->data;
        $this->assertNull($data);
    }
}
