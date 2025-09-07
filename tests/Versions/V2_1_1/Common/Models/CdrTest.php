<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CdrFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Cdr;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class CdrTest extends TestCase
{
    /**
     * @return mixed[][]
     */
    public function getJsonSerializeData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/Cdrs') as $file) {
            if ($file !== '.' && $file !== '..') {
                yield $file => [
                    'payload' => json_decode(file_get_contents(__DIR__ . '/Payloads/Cdrs/' . $file)),
                ];
            }
        }
    }

    /**
     * @param stdClass $payload
     * @dataProvider getJsonSerializeData()
     * @covers       \Chargemap\OCPI\Versions\V2_1_1\Common\Models\Cdr::jsonSerialize()
     */
    public function testJsonSerialize(stdClass $payload): void
    {
        $cdr = CdrFactory::fromJson($payload);

        Assert::assertEquals($payload, json_decode(json_encode($cdr)));
    }

    public static function assertJsonSerialization(?Cdr $cdr, ?stdClass $json): void
    {
        if ($cdr === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($cdr->getId(), $json->id);
            Assert::assertEquals(DateTimeFormatter::format($cdr->getStartDateTime()), $json->start_date_time);
            Assert::assertEquals(DateTimeFormatter::format($cdr->getStopDateTime()), $json->stop_date_time);
            Assert::assertSame($cdr->getAuthId(), $json->auth_id ?? null);
            Assert::assertEquals($cdr->getAuthMethod()->getValue(), $json->auth_method);
            LocationTest::assertJsonSerialization($cdr->getLocation(), $json->location);

            Assert::assertSame($cdr->getMeterId(), $json->meter_id ?? null);
            Assert::assertSame($cdr->getCurrency(), $json->currency);

            Assert::assertCount(count($cdr->getTariffs()), $json->tariffs ?? []);
            Assert::assertCount(count($cdr->getChargingPeriods()), $json->charging_periods);
            foreach ($cdr->getChargingPeriods() as $index => $chargingPeriod) {
                ChargingPeriodTest::assertJsonSerialization($chargingPeriod, $json->charging_periods[$index]);
            }
            Assert::assertSame(count($cdr->getChargingPeriods()), count($json->charging_periods));

            Assert::assertEquals($cdr->getTotalCost(), $json->total_cost);
            Assert::assertSame((float)$json->total_energy, $cdr->getTotalEnergy());
            Assert::assertSame((float)$json->total_time, $cdr->getTotalTime());
            if ($cdr->getTotalParkingTime() !== null) {
                Assert::assertSame($cdr->getTotalParkingTime(), (float)$json->total_parking_time);
            } else {
                Assert::assertNull($json->total_parking_time ?? null);
            }
            
            Assert::assertSame($cdr->getRemark(), $json->remark ?? null);
            
            Assert::assertEquals(DateTimeFormatter::format($cdr->getLastUpdated()), $json->last_updated);
        }
    }
}