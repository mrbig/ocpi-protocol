<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\PartialSessionFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\SessionFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\AuthMethod;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CdrDimension;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CdrDimensionType;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CdrToken;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ChargingPeriod;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Price;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Session;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\SessionStatus;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Tariff;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\TariffType;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\TokenType;
use DateTime;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Common\Models\Tariff
 */
class TariffTest extends TestCase
{
    public static function assertJsonSerialization(?Tariff $tariff, ?stdClass $json): void
    {
        if ($tariff === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($tariff->getCountryCode(), $json->country_code);
            Assert::assertSame($tariff->getPartyId(), $json->party_id);
            Assert::assertSame($tariff->getId(), $json->id);
            Assert::assertSame($tariff->getCurrency(), $json->currency);
            if (is_null($json->type ?? null)) {
                Assert::assertNull($tariff->getType());
            } else {
                Assert::assertEquals(TariffType::from($json->type), $json->type);
            }
            if (empty($tariff->getTariffAltText())) {
                Assert::assertEmpty($json->tariff_alt_text ?? null);
            } else {
                foreach ($tariff->getTariffAltText() as $index => $tariffAltText) {
                    DisplayTextTest::assertJsonSerialization($tariffAltText, $json->tariff_alt_text[$index]);
                }
            }
            Assert::assertSame($tariff->getTariffAltUrl(), $json->tariff_alt_url ?? null);
            PriceTest::assertJsonSerialization($tariff->getMinPrice(), $json->min_price ?? null);
            PriceTest::assertJsonSerialization($tariff->getMaxPrice(), $json->max_price ?? null);
            foreach ($tariff->getElements() as $index => $element) {
                TariffElementTest::assertJsonSerialization($element, $json->elements[$index]);
            }
            if (is_null($json->start_date_time ?? null)) {
                Assert::assertNull($tariff->getStartDateTime());
            } else {
                Assert::assertSame(DateTimeFormatter::format($tariff->getStartDateTime()), $json->start_date_time);
            }
            if (is_null($json->end_date_time ?? null)) {
                Assert::assertNull($tariff->getEndDateTime());
            } else {
                Assert::assertSame(DateTimeFormatter::format($tariff->getEndDateTime()), $json->end_date_time);
            }
            EnergyMixTest::assertJsonSerialization($tariff->getEnergyMix(), $json->energy_mix ?? null);
            Assert::assertSame(DateTimeFormatter::format($tariff->getLastUpdated()), $json->last_updated);
        }
    }
}
