<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\CdrFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\AuthMethod;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Cdr;
use DateTime;
use JsonException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;

class CdrFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/Cdr/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/Cdr/' . $filename),
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

        OcpiTestCase::coerce('V2_2_1/Receiver/CDRs/cdrPostRequest.schema.json', $json);

        $cdr = CdrFactory::fromJson($json);

        self::assertCdr($json, $cdr);
    }

    public static function assertCdr(?stdClass $json, ?Cdr $cdr): void
    {
        if ($json === null) {
            Assert::assertNull($cdr);
        } else {
            Assert::assertSame($json->country_code, $cdr->getCountryCode());
            Assert::assertSame($json->party_id, $cdr->getPartyId());
            Assert::assertSame($json->id, $cdr->getId());
            Assert::assertEquals(new DateTime($json->start_date_time), $cdr->getStartDateTime());
            Assert::assertEquals(new DateTime($json->end_date_time), $cdr->getEndDateTime());
            Assert::assertSame($json->session_id ?? null, $cdr->getSessionId());
            CdrTokenFactoryTest::assertCdrToken($json->cdr_token, $cdr->getCdrToken());
            Assert::assertEquals(new AuthMethod($json->auth_method), $cdr->getAuthMethod());
            Assert::assertSame($json->authorization_reference ?? null, $cdr->getAuthorizationReference());
            CdrLocationFactoryTest::assertCdrLocation($json->cdr_location, $cdr->getCdrLocation());

            Assert::assertSame($json->meter_id ?? null, $cdr->getMeterId());
            Assert::assertSame($json->currency, $cdr->getCurrency());
            foreach ($cdr->getTariffs() as $index => $tariff) {
                TariffFactoryTest::assertTariff($json->tariffs[$index], $tariff);
            }
            Assert::assertCount(count($json->tariffs ?? []), $cdr->getTariffs());
            foreach ($cdr->getChargingPeriods() as $index => $chargingPeriod) {
                ChargingPeriodFactoryTest::assertChargingPeriod($json->charging_periods[$index], $chargingPeriod);
            }
            Assert::assertSame(count($json->charging_periods), count($cdr->getChargingPeriods()));

            SignedDataFactoryTest::assertSignedData($json->signed_data ?? null, $cdr->getSignedData());

            PriceFactoryTest::assertPrice($json->total_cost, $cdr->getTotalCost());
            PriceFactoryTest::assertPrice($json->total_fixed_cost ?? null, $cdr->getTotalFixedCost());
            Assert::assertSame((float)$json->total_energy, $cdr->getTotalEnergy());
            PriceFactoryTest::assertPrice($json->total_energy_cost ?? null, $cdr->getTotalEnergyCost());
            Assert::assertSame((float)$json->total_time, $cdr->getTotalTime());
            PriceFactoryTest::assertPrice($json->total_time_cost ?? null, $cdr->getTotalTimeCost());
            if (property_exists($json, 'total_parking_time')) {
                Assert::assertSame((float)$json->total_parking_time, $cdr->getTotalParkingTime());
            } else {
                Assert::assertNull($cdr->getTotalParkingTime());
            }
            PriceFactoryTest::assertPrice($json->total_parking_cost ?? null, $cdr->getTotalParkingCost());
            PriceFactoryTest::assertPrice($json->total_reservation_cost ?? null, $cdr->getTotalReservationCost());
            
            Assert::assertSame($json->remark ?? null, $cdr->getRemark());
            Assert::assertSame($json->invoice_reference_id ?? null, $cdr->getInvoiceReferenceId());
            Assert::assertSame($json->credit ?? null, $cdr->getCredit());
            Assert::assertSame($json->credit_reference_id ?? null, $cdr->getCreditReferenceId());
            Assert::assertSame($json->homecharging_compensation ?? null, $cdr->getHomechargingCompensation());
            
            Assert::assertEquals(new DateTime($json->last_updated), $cdr->getLastUpdated());
        }
    }
}