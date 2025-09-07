<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tokens\Post;

use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tokens\Post\PostTokenRequest;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\LocationReferences;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\TokenType;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\OcpiTestCase;

class PostTokenRequestTest extends TestCase
{
    public function validParametersProvider(): iterable
    {
        yield ['012345678', null, null];
        yield ['012345678', TokenType::RFID(), null];
        yield ['012345678012345678', TokenType::OTHER(), new LocationReferences("location")];
    }

    /**
     * @dataProvider validParametersProvider
     * @param string $countryCode
     * @param string $partyId
     * @param string $tokenUid
     */
    public function testShouldConstructCorrectQuery(string $tokenUid, ?TokenType $type, ?LocationReferences $location): void
    {
        $request = new PostTokenRequest($tokenUid, $type, $location);
        $requestInterface = $request->getServerRequestInterface(
            Psr17FactoryDiscovery::findServerRequestFactory(),
            null
        );
        $query = '';
        if ($type !== null) {
            $query = 'type='.$type;
        }
        $this->assertSame("/".urlencode($tokenUid)."/authorize", $requestInterface->getUri()->getPath());
        $this->assertSame( $query, $requestInterface->getUri()->getQuery());
        $this->assertSame('POST', $requestInterface->getMethod());
        if ($location) {
            $requestBody = json_decode($requestInterface->getBody()->getContents());
            $this->assertEquals(json_encode($location), json_encode($requestBody));
            OcpiTestCase::coerce('V2_1_1/eMSP/Tokens/tokenPostRequest.schema.json', $requestBody);
        }
    }

    public function invalidParametersProvider(): iterable
    {
        yield 'Token uid is empty' => ['', null];
        yield 'Token uid is too long' => ['0123456780123456780123456780123456780123', null];
    }

    /**
     * @dataProvider invalidParametersProvider
     * @param string $countryCode
     * @param string $partyId
     * @param string $tokenUid
     */
    public function testShouldThrowExceptionWithInvalidParameters(
        string $tokenUid,
        ?TokenType $type
    ): void {
        $this->expectException(InvalidArgumentException::class);
        new PostTokenRequest($tokenUid, $type);
    }
}
