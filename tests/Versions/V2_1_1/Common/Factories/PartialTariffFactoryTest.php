<?php

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\PartialTariffFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\PartialTariff;
use DateTime;
use JsonException;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_1_1\Common\Factories\PartialTariffFactory
 */
class PartialTariffFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/PartialTariff/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/PartialTariff/' . $filename),
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

        OcpiTestCase::coerce('V2_1_1/eMSP/Tariffs/tariffPatchRequest.schema.json', $json);

        $tariff = PartialTariffFactory::fromJson($json);

        self::assertPartialTariff($json, $tariff);
    }

    public static function assertPartialTariff($json, PartialTariff $tariff): void
    {
        if (property_exists($json, 'id')) {
            self::assertTrue($tariff->hasId());
            self::assertSame($json->id, $tariff->getId());
        } else {
            self::assertFalse($tariff->hasId());
        }
        if (property_exists($json, 'currency')) {
            self::assertTrue($tariff->hasCurrency());
            self::assertSame($json->currency, $tariff->getCurrency());
        } else {
            self::assertFalse($tariff->hasCurrency());
        }
        if (property_exists($json, 'tariff_alt_text')) {
            self::assertTrue($tariff->hasTariffAltText());
            self::assertCount(count($json->tariff_alt_text ?? []), $tariff->getTariffAltText());
        } else {
            self::assertFalse($tariff->hasTariffAltText());
        }
        if (property_exists($json, 'tariff_alt_url')) {
            self::assertTrue($tariff->hasTariffAltUrl());
            self::assertSame($json->tariff_alt_url, $tariff->getTariffAltUrl());
        } else {
            self::assertFalse($tariff->hasTariffAltUrl());
        }
        if (property_exists($json, 'elements')) {
            self::assertTrue($tariff->hasElements());
            self::assertCount(count($json->elements ?? []), $tariff->getElements());
        } else {
            self::assertFalse($tariff->hasElements());
        }
        if (property_exists($json, 'energy_mix')) {
            self::assertTrue($tariff->hasEnergyMix());
            self::assertEquals($json->energy_mix, $tariff->getEnergyMix());
        } else {
            self::assertFalse($tariff->hasEnergyMix());
        }

        if (property_exists($json, 'last_updated')) {
            self::assertTrue($tariff->hasLastUpdated());
            self::assertEquals(new DateTime($json->last_updated), $tariff->getLastUpdated());
        } else {
            self::assertFalse($tariff->hasLastUpdated());
        }
    }
}
