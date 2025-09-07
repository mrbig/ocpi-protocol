<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\Get;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\LocationFactory;
use Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\Get\ReceiverLocationGetResponse;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Models\LocationTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Receiver\Locations\Evses\Get\OcpiEmspEvseGetResponse
 */
class ResponseConstructionTest extends TestCase
{
    public function validPayloadsProvider(): iterable
    {
        foreach (scandir(__DIR__ . '/payloads/valid/') as $filename) {
            if (!is_dir(__DIR__ . '/payloads/valid/' . $filename)) {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/payloads/valid/' . $filename),
                ];
            }
        }
    }

    /**
     * @dataProvider validPayloadsProvider
     * @param string $payload
     * @throws InvalidPayloadException
     */
    public function testShouldSerializeLocationCorrectlyWithFullPayload(string $payload)
    {
        $location = LocationFactory::fromJson(json_decode($payload));
        $response = new ReceiverLocationGetResponse($location);

        $responseInterface = $response->getResponseInterface();
        $this->assertSame(OcpiSuccessHttpCode::HTTP_OK, $responseInterface->getStatusCode());
        $json = json_decode($responseInterface->getBody()->getContents());
        OcpiTestCase::coerce('V2_2_1/Receiver/Locations/locationGetResponse.schema.json', $json);
        LocationTest::assertJsonSerialization($location, $json->data);
    }
}
