<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Sessions\Put;

use Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Sessions\Put\SenderSessionPutRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories\ChargingPreferencesFactoryTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Sessions\Put\SenderSessionPutRequest
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
    public function testShouldConstructRequestWithPayload(string $payload): void
    {
        $serverRequestInterface = Psr17FactoryDiscovery::findServerRequestFactory()
            ->createServerRequest('GET', 'randomUrl')
            ->withQueryParams(['type' => 'rfid'])
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($payload));

        $request = new SenderSessionPutRequest($serverRequestInterface, '101');

        $this->assertEquals('101', $request->getSessionId());

        ChargingPreferencesFactoryTest::assertChargingPreferences($request->getJsonBody(), $request->getPreferences());
    }

}
