<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\ConnectorFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Connector;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ConnectorFormat;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ConnectorType;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\PowerType;
use DateTime;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class ConnectorFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/Connector/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/Connector/' . $filename),
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

        $connector = ConnectorFactory::fromJson($json);

        self::assertConnector($json, $connector);
    }

    public static function assertConnector(?stdClass $json, ?Connector $connector): void
    {
        if($json === null) {
            Assert::assertNull($connector);
        } else {
            Assert::assertEquals(new DateTime($json->last_updated), $connector->getLastUpdated());
            Assert::assertSame($json->id, $connector->getId());
            Assert::assertSame($json->max_amperage, $connector->getMaxAmperage());
            Assert::assertEquals(new ConnectorFormat($json->format), $connector->getFormat());
            Assert::assertEquals(new PowerType($json->power_type), $connector->getPowerType());
            Assert::assertEquals(new ConnectorType($json->standard), $connector->getStandard());
            Assert::assertSame($json->terms_and_conditions ?? null, $connector->getTermsAndConditions());
            Assert::assertSame($json->max_voltage, $connector->getMaxVoltage());
            Assert::assertSame($json->max_electric_power ?? null, $connector->getMaxElectricPower());


            if(!property_exists($json, 'tariff_ids') || $json->tariff_ids === null) {
                Assert::assertCount(0, $connector->getTariffIds());
            } else {
                foreach($json->tariff_ids as $index => $tariffId) {
                    Assert::assertEquals($tariffId, $connector->getTariffIds()[$index]);
                }
            }
        }
    }
}