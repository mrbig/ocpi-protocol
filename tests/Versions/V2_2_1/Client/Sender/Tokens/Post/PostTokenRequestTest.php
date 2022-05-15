<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tokens\Post;

use Chargemap\OCPI\Versions\V2_2_1\Client\Sender\Tokens\Post\PostTokenRequest;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\TokenType;
use Http\Discovery\Psr17FactoryDiscovery;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PostTokenRequestTest extends TestCase
{
    public function validParametersProvider(): iterable
    {
        yield ['012345678', null];
        yield ['012345678', TokenType::RFID()];
        yield ['012345678012345678', TokenType::APP_USER()];
    }

    /**
     * @dataProvider validParametersProvider
     * @param string $countryCode
     * @param string $partyId
     * @param string $tokenUid
     */
    public function testShouldConstructCorrectQuery(string $tokenUid, ?TokenType $type): void
    {
        $request = new PostTokenRequest($tokenUid, $type);
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
