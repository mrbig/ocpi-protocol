<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tokens\Post;

use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Versions\V2_1_1\Client\Emsp\Tokens\Post\PostTokenResponse;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;

class PostTokenResponseTest extends TestCase
{
    public function validPayloadProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/valid/') as $filename) {
            if (!is_dir(__DIR__ . '/payloads/valid/' . $filename)) {
                yield basename($filename, '.json') => [__DIR__ . '/payloads/valid/' . $filename];
            }
        }
    }

    /**
     * @dataProvider validPayloadProvider
     * @param string $filename
     */
    public function testJsonSchema(string $filename): void
    {
        $this->expectNotToPerformAssertions();
        $serverResponse = Psr17FactoryDiscovery::findResponseFactory()->createResponse(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(
                Psr17FactoryDiscovery::findStreamFactory()->createStream(file_get_contents($filename))
            );

        PostTokenResponse::from($serverResponse)->getAuthorizationInfo();
    }

    public function invalidPayloadProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/invalid/') as $filename) {
            if (!is_dir(__DIR__ . '/payloads/invalid/' . $filename)) {
                yield basename($filename, '.json') => [__DIR__ . '/payloads/invalid/' . $filename];
            }
        }
    }

    /**
     * @dataProvider invalidPayloadProvider
     * @param string $filename
     */
    public function testShouldThrowExceptionWithInvalidPayload(string $filename): void
    {
        $serverResponse = Psr17FactoryDiscovery::findResponseFactory()->createResponse(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(
                Psr17FactoryDiscovery::findStreamFactory()->createStream(file_get_contents($filename))
            );

        $this->expectException(OcpiInvalidPayloadClientError::class);

        PostTokenResponse::from($serverResponse)->getAuthorizationInfo();
    }
}
