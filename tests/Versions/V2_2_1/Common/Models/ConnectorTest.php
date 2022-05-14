<?php

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Connector;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Common\Models\Connector
 */
class ConnectorTest
{
    public static function assertJsonSerialization(?Connector $connector, ?stdClass $json): void
    {
        if ($connector === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($connector->getId(), $json->id);
            Assert::assertSame($connector->getStandard()->getValue(), $json->standard);
            Assert::assertSame($connector->getFormat()->getValue(), $json->format);
            Assert::assertSame($connector->getPowerType()->getValue(), $json->power_type);
            Assert::assertSame($connector->getMaxVoltage(), $json->max_voltage);
            Assert::assertSame($connector->getMaxAmperage(), $json->max_amperage);
            Assert::assertSame($connector->getMaxElectricPower(), $json->max_electric_power ?? null);
            Assert::assertSame($connector->getTariffId(), $json->tariff_id ?? null);
            Assert::assertSame($connector->getTermsAndConditions(), $json->terms_and_conditions ?? null);
            Assert::assertEquals(DateTimeFormatter::format($connector->getLastUpdated()), $json->last_updated);
        }
    }
}
