<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\CdrLocationFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CdrLocation;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ConnectorFormat;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ConnectorType;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\PowerType;
use JsonException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;

class CdrLocationFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/CdrLocation/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/CdrLocation/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @throws JsonException|InvalidPayloadException
     * @dataProvider getFromJsonData()
     */
    public function testFromJson(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        OcpiTestCase::coerce('V2_2_1/Common/cdr.schema.json#/properties/cdr_location', $json );

        $location = CdrLocationFactory::fromJson($json);

        self::assertCdrLocation($json, $location);
    }

    public static function assertCdrLocation(?stdClass $json, ?CdrLocation $location): void
    {
        if($json === null) {
            Assert::assertNull($location);
        } else {
            Assert::assertSame($json->id, $location->getId());
            Assert::assertSame($json->name ?? null, $location->getName());
            Assert::assertSame($json->address, $location->getAddress());
            Assert::assertSame($json->city, $location->getCity());
            Assert::assertSame($json->postal_code ?? null, $location->getPostalCode());
            Assert::assertSame($json->state ?? null, $location->getState());
            Assert::assertSame($json->country, $location->getCountry());
            GeoLocationFactoryTest::assertGeolocation($json->coordinates, $location->getCoordinates());
            Assert::assertSame($json->evse_uid, $location->getEvseUid());
            Assert::assertSame($json->evse_id, $location->getEvseId());
            Assert::assertSame($json->connector_id, $location->getConnectorId());
            Assert::assertEquals(new ConnectorType($json->connector_standard), $location->getConectorStandard());
            Assert::assertEquals(new ConnectorFormat($json->connector_format), $location->getConnectorFormat());
            Assert::assertEquals(new PowerType($json->connector_power_type), $location->getConnectorPowerType());
        }
    }
}