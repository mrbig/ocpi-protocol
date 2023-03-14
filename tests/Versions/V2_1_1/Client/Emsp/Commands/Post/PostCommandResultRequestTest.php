<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Commands\Post;

use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Commands\Post\PostCommandResultRequest;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CommandResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CommandResponseType;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\OcpiTestCase;

class PostCommandResultRequestTest extends TestCase
{
    public function validParametersProvider(): iterable
    {
        yield ['http://example.com', new CommandResponse(CommandResponseType::ACCEPTED())];
        yield ['http://example.com', new CommandResponse(CommandResponseType::ACCEPTED())];
        yield [
            'https://example.com/ocpi/emsp/RESERVE_NOW/1234',
            new CommandResponse(CommandResponseType::REJECTED())
        ];
        yield ['https://example.com/ocpi/emsp/RESERVE_NOW/?id=1234', new CommandResponse(CommandResponseType::UNKNOWN_SESSION())];
    }

    /**
     * @dataProvider validParametersProvider
     * @param string $responseUrl
     * @param CommandResponse $response
     */
    public function testShouldConstructCorrectQuery(string $responseUrl, CommandResponse $response): void
    {
        $request = new PostCommandResultRequest($responseUrl, $response);
        $requestInterface = $request->getServerRequestInterface(
            Psr17FactoryDiscovery::findServerRequestFactory(),
            null
        );
        $uri_parts = parse_url($responseUrl);
        $this->assertSame($uri_parts['path'] ?? '/', $requestInterface->getUri()->getPath());
        if (!empty($uri_parts['query'])) {
            $this->assertSame( $uri_parts['query'], $requestInterface->getUri()->getQuery());
        }
        $this->assertSame('POST', $requestInterface->getMethod());
        $requestBody = json_decode($requestInterface->getBody()->getContents());
        $this->assertEquals($response->getResult(), $requestBody->result);

        OcpiTestCase::coerce('V2_1_1/eMSP/Commands/commandResultPostRequest.schema.json', $requestBody);
    }

}
