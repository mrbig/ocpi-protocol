<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\GetListing;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\LocationFactory;
use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\GetListing\OcpiCpoLocationGetListingRequest;
use Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations\GetListing\OcpiCpoLocationGetListingResponse;
use Http\Discovery\Psr17FactoryDiscovery;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models\LocationTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Server\CpoLocationsGetListing\OcpiCpoLocationGetListingResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function testShouldReturnEmptyArrayWithoutTokens(): void
    {
        $response = new OcpiCpoLocationGetListingResponse(self::getRequest(), 0, 10);
        $responseInterface = $response->getResponseInterface();
        $this->assertSame([], json_decode($responseInterface->getBody()->getContents(), true)['data']);
    }

    private function getRequest(): OcpiCpoLocationGetListingRequest
    {
        return new OcpiCpoLocationGetListingRequest(
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
    public function testShouldReturnDataWithLocations(string $payload): void
    {
        $response = new OcpiCpoLocationGetListingResponse(self::getRequest(), 0, 10);
        $locations = [];
        foreach (json_decode($payload)->data as $index => $jsonLocation) {
            $location = LocationFactory::fromJson($jsonLocation);
            $locations[$index] = $location;
            $response->addLocation($location);
        }
        $responseInterface = $response->getResponseInterface();
        $payload = json_decode($responseInterface->getBody()->getContents());
        OcpiTestCase::coerce('V2_2_1/Sender/Locations/locationGetListingResponse.schema.json', $payload);
        foreach ($payload->data as $index => $jsonLocation) {
            LocationTest::assertJsonSerialization($locations[$index], $jsonLocation);
        }
    }
}
