<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\ChargingPreferencesFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ChargingPreferences;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ProfileType;
use DateTime;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class ChargingPreferencesFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/ChargingPreferences/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/ChargingPreferences/' . $filename),
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

        $connector = ChargingPreferencesFactory::fromJson($json);

        self::assertChargingPreferences($json, $connector);
    }

    public static function assertChargingPreferences(?stdClass $json, ?ChargingPreferences $preferences): void
    {
        if($json === null) {
            Assert::assertNull($preferences);
        } else {
            Assert::assertEquals(new ProfileType($json->profile_type), $preferences->getProfileType());
            Assert::assertEquals(!empty($json->departure_time) ? new DateTime($json->departure_time) : null, $preferences->getDepartureTime());
            Assert::assertSame($json->energy_needed ?? null, $preferences->getEnergyNeeded());
            Assert::assertSame($json->discharge_allowed ?? null, $preferences->getDischargeAllowed());
        }
    }
}