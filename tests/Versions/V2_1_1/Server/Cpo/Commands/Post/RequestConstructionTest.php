<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Commands\Post;


use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Commands\Post\ReserveNowRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Commands\Post\StartSessionRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Commands\Post\StopSessionRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Commands\Post\UnlockConnectorRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\ServerRequestInterface;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\ReserveNowFactoryTest;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\StartSessionFactoryTest;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\StopSessionFactoryTest;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories\UnlockConnectorFactoryTest;


/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Command\Post\ReserveNowRequest
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Command\Post\StartSessionRequest
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Command\Post\StopSessionRequest
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Command\Post\UnlocConnectorRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function parametersProvider(string $type, string $command): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/' . $type . '/' . $command . '/') as $filename) {
            if( $filename !== '.' && $filename !== '..') {
                yield basename($filename, '.json') => [
                    'payload' => file_get_contents( __DIR__ . '/payloads/' . $type . '/' . $command . '/' . $filename ),
                ];
            }
        }
    }

    public function ReserveNowParametersProvider(): iterable
    {
        return $this->parametersProvider('valid', 'ReserveNow');
    }

    public function startSessionParametersProvider(): iterable
    {
        return $this->parametersProvider('valid', 'StartSession');
    }

    public function invalidStartSessionParametersProvider(): iterable
    {
        return $this->parametersProvider('invalid', 'StartSession');
    }

    public function stopSessionParametersProvider(): iterable
    {
        return $this->parametersProvider('valid', 'StopSession');
    }

    public function unlockConnectorParametersProvider(): iterable
    {
        return $this->parametersProvider('valid', 'UnlockConnector');
    }

    /**
     * @param string $payload
     * @dataProvider reserveNowParametersProvider()
     */
    public function testReserveNow(string $payload): void
    {
        $serverRequestInterface = $this->createRequest($payload);
        $request = new ReserveNowRequest($serverRequestInterface, "RESERVE_NOW");

        ReserveNowFactoryTest::assertReserveNow($request->getJsonBody(), $request->getCommand());
    }

    /**
     * @param string $payload
     * @dataProvider startSessionParametersProvider()
     */
    public function testStartSession(string $payload): void
    {
        $serverRequestInterface = $this->createRequest($payload);
        $request = new StartSessionRequest($serverRequestInterface, "START_SESSION");

        StartSessionFactoryTest::assertStartSession($request->getJsonBody(), $request->getCommand());
    }

    /**
     * @param string $payload
     * @dataProvider invalidStartSessionParametersProvider()
     */
    public function testInvalidStartSession(string $payload): void
    {
        $this->expectException(OcpiInvalidPayloadClientError::class);
        $serverRequestInterface = $this->createRequest($payload);
        new StartSessionRequest($serverRequestInterface, "START_SESSION");
    }

    /**
     * @param string $payload
     * @dataProvider stopSessionParametersProvider()
     */
    public function testStopSession(string $payload): void
    {
        $serverRequestInterface = $this->createRequest($payload);
        $request = new StopSessionRequest($serverRequestInterface, "STOP_SESSION");

        StopSessionFactoryTest::assertStopSession($request->getJsonBody(), $request->getCommand());
    }

    /**
     * @param string $payload
     * @dataProvider unlockConnectorParametersProvider()
     */
    public function testUnlockConnector($payload): void
    {
        $serverRequestInterface = $this->createRequest($payload);
        $request = new UnlockConnectorRequest($serverRequestInterface, "UNLOCK_CONNECTOR");

        UnlockConnectorFactoryTest::assertUnlockConnetor($request->getJsonBody(), $request->getCommand());
    }

    private function createRequest(string $payload): ServerRequestInterface
    {
        return Psr17FactoryDiscovery::findServerRequestFactory()
            ->createServerRequest('GET', 'randomUrl')
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($payload));
    }
    
}
