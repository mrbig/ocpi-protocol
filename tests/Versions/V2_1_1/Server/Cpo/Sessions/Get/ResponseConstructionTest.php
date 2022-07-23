<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Sessions\Get;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\SessionFactory;
use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Sessions\GetListing\OcpiCpoSessionGetListingRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Sessions\GetListing\OcpiCpoSessionGetListingResponse;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models\SessionTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\Sessions\OcpiCpoSessionGetListingResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function testShouldReturnEmptyArrayWithoutTokens(): void
    {
        $response = new OcpiCpoSessionGetListingResponse(self::getRequest(), 0, 10);
        $responseInterface = $response->getResponseInterface();
        $this->assertSame([], json_decode($responseInterface->getBody()->getContents(), true)['data']);
    }

    private function getRequest(): OcpiCpoSessionGetListingRequest
    {
        return new OcpiCpoSessionGetListingRequest(
            Psr17FactoryDiscovery::findServerRequestFactory()->createServerRequest('GET', '/test?offset=10&limit=10')
                ->withQueryParams(['offset' => '10', 'limit' => '10'])
                ->withHeader('Authorization', 'Token 01234567-0123-0123-0123-0123456789ab')
        );
    }

    public function validPayloadsProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/valid/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield basename($filename, '.json') => [
                    'payload' => file_get_contents(__DIR__ . '/payloads/valid/' . $filename),
                ];
            }
        }
    }

    /**
     * @dataProvider validPayloadsProvider
     * @param string $payload
     */
    public function testShouldReturnDataWithSessions(string $payload): void
    {
        $response = new OcpiCpoSessionGetListingResponse(self::getRequest(), 0, 10);
        $sessions = [];
        foreach (json_decode($payload)->data as $index => $jsonSession) {
            $session = SessionFactory::fromJson($jsonSession);
            $sessions[$index] = $session;
            $response->addSession($session);
        }
        $responseInterface = $response->getResponseInterface();
        $payload = json_decode($responseInterface->getBody()->getContents());
        OcpiTestCase::coerce('V2_1_1/CPO/Server/Sessions/sessionGetResponse.schema.json', $payload);
        foreach ($payload->data as $index => $jsonSession) {
            SessionTest::assertJsonSerialization($sessions[$index], $jsonSession);
        }
    }
}
