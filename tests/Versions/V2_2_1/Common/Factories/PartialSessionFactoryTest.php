<?php

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\PartialSessionFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\PartialSession;
use DateTime;
use JsonException;
use PHPUnit\Framework\TestCase;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;
use Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Models\CdrTokenTest;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Common\Factories\PartialSessionFactory
 */
class PartialSessionFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/PartialSession/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/PartialSession/' . $filename),
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

        OcpiTestCase::coerce('V2_2_1/Receiver/Sessions/sessionPatchRequest.schema.json', $json);

        $session = PartialSessionFactory::fromJson($json);

        self::assertPartialSession($json, $session);
    }

    public static function assertPartialSession($json, PartialSession $session): void
    {
        if (property_exists($json, 'country_code')) {
            self::assertTrue($session->hasCountryCode());
            self::assertSame($json->country_code, $session->getCountryCode());
        } else {
            self::assertFalse($session->hasCountryCode());
        }
        if (property_exists($json, 'party_id')) {
            self::assertTrue($session->hasPartyId());
            self::assertSame($json->party_id, $session->getPartyId());
        } else {
            self::assertFalse($session->hasPartyId());
        }
        if (property_exists($json, 'id')) {
            self::assertTrue($session->hasId());
            self::assertSame($json->id, $session->getId());
        } else {
            self::assertFalse($session->hasId());
        }
        if (property_exists($json, 'start_date_time')) {
            self::assertTrue($session->hasStartDateTime());
            self::assertEquals(new DateTime($json->start_date_time), $session->getStartDateTime());
        } else {
            self::assertFalse($session->hasStartDateTime());
        }
        if (property_exists($json, 'end_date_time')) {
            self::assertTrue($session->hasEndDateTime());
            self::assertEquals(new DateTime($json->end_date_time), $session->getEndDateTime());
        } else {
            self::assertFalse($session->hasEndDateTime());
        }
        if (property_exists($json, 'kwh')) {
            self::assertTrue($session->hasKwh());
            self::assertSame((float)$json->kwh, $session->getKwh());
        } else {
            self::assertFalse($session->hasKwh());
        }
        if (property_exists($json, 'cdr_token')) {
            self::assertTrue($session->hasCdrToken());
            CdrTokenFactoryTest::assertCdrToken($json->cdr_token, $session->getCdrToken());
        } else {
            self::assertFalse($session->hasCdrToken());
        }
        if (property_exists($json, 'auth_method')) {
            self::assertTrue($session->hasAuthMethod());
            self::assertEquals($json->auth_method, $session->getAuthMethod()->getValue());
        } else {
            self::assertFalse($session->hasAuthMethod());
        }
        if (property_exists($json, 'authorization_reference')) {
            self::assertTrue($session->hasAuthorizationReference());
            self::assertSame($json->authorization_reference, $session->getAuthorizationReference());
        } else {
            self::assertFalse($session->hasAuthorizationReference());
        }
        if (property_exists($json, 'location')) {
            self::assertTrue($session->hasLocation());
            LocationFactoryTest::assertLocation($json->location, $session->getLocation());
        } else {
            self::assertFalse($session->hasLocation());
        }
        if (property_exists($json, 'evse_uid')) {
            self::assertTrue($session->hasEvseUid());
            self::assertSame($json->evse_uid, $session->getEvseUid());
        } else {
            self::assertFalse($session->hasEvseUid());
        }
        if (property_exists($json, 'connector_id')) {
            self::assertTrue($session->hasConnectorId());
            self::assertSame($json->connector_id, $session->getConnectorId());
        } else {
            self::assertFalse($session->hasConnectorId());
        }
        if (property_exists($json, 'meter_id')) {
            self::assertTrue($session->hasMeterId());
            self::assertSame($json->meter_id, $session->getMeterId());
        } else {
            self::assertFalse($session->hasMeterId());
        }
        if (property_exists($json, 'currency')) {
            self::assertTrue($session->hasCurrency());
            self::assertSame($json->currency, $session->getCurrency());
        } else {
            self::assertFalse($session->hasCurrency());
        }
        if (property_exists($json, 'charging_periods')) {
            self::assertTrue($session->hasChargingPeriods());
            self::assertCount(count($json->charging_periods ?? []), $session->getChargingPeriods());
        } else {
            self::assertFalse($session->hasChargingPeriods());
        }
        if (property_exists($json, 'total_cost')) {
            self::assertTrue($session->hasTotalCost());
            
            PriceFactoryTest::assertPrice($json->total_cost, $session->getTotalCost());
        } else {
            self::assertFalse($session->hasTotalCost());
        }
        if (property_exists($json, 'status')) {
            self::assertTrue($session->hasStatus());
            self::assertSame($json->status, $session->getStatus()->getValue());
        } else {
            self::assertFalse($session->hasStatus());
        }
        if (property_exists($json, 'last_updated')) {
            self::assertTrue($session->hasLastUpdated());
            self::assertEquals(new DateTime($json->last_updated), $session->getLastUpdated());
        } else {
            self::assertFalse($session->hasLastUpdated());
        }
    }
}
