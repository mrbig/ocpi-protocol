<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\Get;

use Chargemap\OCPI\Common\Server\StatusCodes\OcpiSuccessHttpCode;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\LocationFactory;
use Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\Get\SenderLocationGetResponse;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Models\LocationTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\Get\SenderLocationGetResponse
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
     */
    public function testShouldSerializeLocationCorrectlyWithFullPayload(string $payload): void
    {
        $location = LocationFactory::fromJson(json_decode($payload));
        $response = new SenderLocationGetResponse($location);

        $responseInterface = $response->getResponseInterface();
        $this->assertSame(OcpiSuccessHttpCode::HTTP_OK, $responseInterface->getStatusCode());
        $json = json_decode($responseInterface->getBody()->getContents());
        OcpiTestCase::coerce('V2_2_1/eMSP/Server/Locations/locationGetResponse.schema.json', $json);
        LocationTest::assertJsonSerialization($location, $json->data);
    }
}
