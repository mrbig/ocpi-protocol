<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\CdrFactory;
use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Cdr;
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
     * @covers       \Chargemap\OCPI\Versions\V2_2_1\Common\Models\Cdr::jsonSerialize()
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
            Assert::assertSame($cdr->getCountryCode(), $json->country_code);
            Assert::assertSame($cdr->getPartyId(), $json->party_id);
            Assert::assertSame($cdr->getId(), $json->id);
            Assert::assertEquals(DateTimeFormatter::format($cdr->getStartDateTime()), $json->start_date_time);
            Assert::assertEquals(DateTimeFormatter::format($cdr->getEndDateTime()), $json->end_date_time);
            Assert::assertSame($cdr->getSessionId(), $json->session_id ?? null);
            CdrTokenTest::assertJsonSerialization($cdr->getCdrToken(), $json->cdr_token);
            Assert::assertEquals($cdr->getAuthMethod()->getValue(), $json->auth_method);
            Assert::assertSame($cdr->getAuthorizationReference(), $json->authorization_reference ?? null);
            

            Assert::assertSame($cdr->getMeterId(), $json->meter_id ?? null);
            Assert::assertSame($cdr->getCurrency(), $json->currency);

            Assert::assertCount(count($cdr->getTariffs()), $json->tariffs ?? []);
            foreach ($cdr->getChargingPeriods() as $index => $chargingPeriod) {
                ChargingPeriodTest::assertJsonSerialization($chargingPeriod, $json->charging_periods[$index]);
            }
            Assert::assertSame(count($cdr->getChargingPeriods()), count($json->charging_periods));

            PriceTest::assertJsonSerialization($cdr->getTotalCost(), $json->total_cost);
            PriceTest::assertJsonSerialization($cdr->getTotalFixedCost(), $json->total_fixed_cost ?? null);
            Assert::assertSame((float)$json->total_energy, $cdr->getTotalEnergy());
            PriceTest::assertJsonSerialization($cdr->getTotalEnergyCost(), $json->total_energy_cost ?? null);
            Assert::assertSame((float)$json->total_time, $cdr->getTotalTime());
            PriceTest::assertJsonSerialization($cdr->getTotalTimeCost(), $json->total_time_cost ?? null);
            if ($cdr->getTotalParkingTime() !== null) {
                Assert::assertSame($cdr->getTotalParkingTime(), (float)$json->total_parking_time);
            } else {
                Assert::assertNull($json->total_parking_time ?? null);
            }
            PriceTest::assertJsonSerialization($json->total_parking_cost ?? null, $cdr->getTotalParkingCost());
            PriceTest::assertJsonSerialization($json->total_reservation_cost ?? null, $cdr->getTotalReservationCost());
            
            Assert::assertSame($cdr->getRemark(), $json->remark ?? null);
            Assert::assertSame($cdr->getInvoiceReferenceId(), $json->invoice_reference_id ?? null);
            Assert::assertSame($cdr->getCredit(), $json->credit ?? null);
            Assert::assertSame($cdr->getCreditReferenceId(), $json->credit_reference_id ?? null);
            Assert::assertSame($cdr->getHomechargingCompensation(), $json->homecharging_compensation ?? null);
            
            Assert::assertEquals(DateTimeFormatter::format($cdr->getLastUpdated()), $json->last_updated);
        }
    }
}