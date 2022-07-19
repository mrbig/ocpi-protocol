<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Commands\Post;

use Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Commands\Post\CommandResultRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\ServerRequestInterface;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories\CommandResultFactoryTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tokens\Put\ReceiverTokenPutRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function validParametersProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/valid/') as $filename) {
            if( $filename !== '.' && $filename !== '..') {
                yield basename($filename, '.json') => [
                    'payload' => file_get_contents( __DIR__ . '/payloads/valid/' . $filename ),
                ];
            }
        }
    }


    /**
     * @param string $payload
     * @dataProvider validParametersProvider()
     */
    public function testValidRequest(string $payload): void
    {
        $serverRequestInterface = $this->createRequest($payload);
        $request = new CommandResultRequest($serverRequestInterface);

        CommandResultFactoryTest::assertCommandResult($request->getJsonBody(), $request->getResult());
    }

    
    private function createRequest(string $payload): ServerRequestInterface
    {
        return Psr17FactoryDiscovery::findServerRequestFactory()
            ->createServerRequest('GET', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($payload));
    }
    
}
