<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Common\Server\Errors\OcpiInvalidPayloadClientError;
use Chargemap\OCPI\Common\Utils\PayloadValidation;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\GeoLocationFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\GeoLocation;
use JsonSchema\Validator;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class GeoLocationFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/GeoLocation/Valid/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/GeoLocation/Valid/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @throws \JsonException
     * @dataProvider getFromJsonData()
     */
    public function testFromJson(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $this->coerce( realpath( __DIR__.'/../../../../../src/Versions/V2_1_1/Server/Emsp/Schemas/common.json' ). '#/definitions/geo_location', $json );

        $geolocation = GeoLocationFactory::fromJson($json);

        self::assertGeolocation($json, $geolocation);
    }

    public function getInvalidFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/GeoLocation/Invalid/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/GeoLocation/Invalid/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @dataProvider getInvalidFromJsonData()
     */
    public function testInvalidFromJson(string $payload): void
    {
        $this->expectException(InvalidPayloadException::class);

        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $this->coerce( realpath( __DIR__.'/../../../../../src/Versions/V2_1_1/Server/Emsp/Schemas/common.json' ). '#/definitions/geo_location', $json );
    }

    public function coerce(string $schemaPath, stdClass $object): void
    {
        $jsonSchemaValidation = new Validator();

        $definition = (object)[
            '$ref' => 'file://' . $schemaPath
        ];

        $jsonSchemaValidation->coerce($object, $definition);

        if (!$jsonSchemaValidation->isValid()) {
            throw new InvalidPayloadException('Payload does not validate');
        }
    }

    public static function assertGeolocation(?stdClass $json, ?GeoLocation $geolocation): void
    {
        if($json === null) {
            Assert::assertNull($geolocation);
        } else {
            Assert::assertSame($json->latitude, $geolocation->getLatitude());
            Assert::assertSame($json->longitude, $geolocation->getLongitude());
        }
    }
}