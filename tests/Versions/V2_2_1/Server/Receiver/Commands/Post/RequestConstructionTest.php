<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Commands\Post;


use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Commands\Post\CancelReservationRequest;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Commands\Post\ReserveNowRequest;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Commands\Post\StartSessionRequest;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Commands\Post\StopSessionRequest;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Commands\Post\UnlockConnectorRequest;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Message\ServerRequestInterface;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories\CancelReservationFactoryTest;
use Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories\ReserveNowFactoryTest;
use Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories\StartSessionFactoryTest;
use Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories\StopSessionFactoryTest;
use Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories\UnlockConnectorFactoryTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Tokens\Put\ReceiverTokenPutRequest
 */
class RequestConstructionTest extends OcpiTestCase
{
    public function validParametersProvider(string $command): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/valid/' . $command . '/') as $filename) {
            if( $filename !== '.' && $filename !== '..') {
                yield basename($filename, '.json') => [
                    'command' => $command,
                    'payload' => file_get_contents( __DIR__ . '/payloads/valid/' . $command . '/' . $filename ),
                ];
            }
        }
    }

    public function cancelReservationParametersProvider(): iterable
    {
        return $this->validParametersProvider('CancelReservation');
    }

    public function ReserveNowParametersProvider(): iterable
    {
        return $this->validParametersProvider('ReserveNow');
    }

    public function startSessionParametersProvider(): iterable
    {
        return $this->validParametersProvider('StartSession');
    }

    public function stopSessionParametersProvider(): iterable
    {
        return $this->validParametersProvider('StopSession');
    }

    public function unlockConnectorParametersProvider(): iterable
    {
        return $this->validParametersProvider('UnlockConnector');
    }

    /**
     * @param string $payload
     * @dataProvider cancelReservationParametersProvider()
     */
    public function testCancelReservation(string $command, string $payload): void
    {
        $serverRequestInterface = $this->createRequest($command, $payload);
        $request = new CancelReservationRequest($serverRequestInterface, "CANCEL_RESERVATION");

        CancelReservationFactoryTest::assertCancelReservation($request->getJsonBody(), $request->getCommand());
    }

    /**
     * @param string $payload
     * @dataProvider reserveNowParametersProvider()
     */
    public function testReserveNow(string $command, string $payload): void
    {
        $serverRequestInterface = $this->createRequest($command, $payload);
        $request = new ReserveNowRequest($serverRequestInterface, "RESERVE_NOW");

        ReserveNowFactoryTest::assertReserveNow($request->getJsonBody(), $request->getCommand());
    }

    /**
     * @param string $payload
     * @dataProvider startSessionParametersProvider()
     */
    public function testStartSession(string $command, string $payload): void
    {
        $serverRequestInterface = $this->createRequest($command, $payload);
        $request = new StartSessionRequest($serverRequestInterface, "START_SESSION");

        StartSessionFactoryTest::assertStartSession($request->getJsonBody(), $request->getCommand());
    }

    /**
     * @param string $payload
     * @dataProvider stopSessionParametersProvider()
     */
    public function testStopSession(string $command, string $payload): void
    {
        $serverRequestInterface = $this->createRequest($command, $payload);
        $request = new StopSessionRequest($serverRequestInterface, "STOP_SESSION");

        StopSessionFactoryTest::assertStopSession($request->getJsonBody(), $request->getCommand());
    }

    /**
     * @param string $payload
     * @dataProvider unlockConnectorParametersProvider()
     */
    public function testUnlockConnector(string $command, string $payload): void
    {
        $serverRequestInterface = $this->createRequest($command, $payload);
        $request = new UnlockConnectorRequest($serverRequestInterface, "UNLOCK_CONNECTOR");

        UnlockConnectorFactoryTest::assertUnlockConnetor($request->getJsonBody(), $request->getCommand());
    }

    private function createRequest(string $command, string $payload): ServerRequestInterface
    {
        return Psr17FactoryDiscovery::findServerRequestFactory()
            ->createServerRequest('GET', 'randomUrl')
            ->withQueryParams(['command' => $command])
            ->withHeader('Authorization', 'Token IpbJOXxkxOAuKR92z0nEcmVF3Qw09VG7I7d/WCg0koM=')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream($payload));
    }
    
}
