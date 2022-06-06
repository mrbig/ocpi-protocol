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
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\TokenType;
use DateTime;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Common\Models\Session
 */
class SessionTest extends TestCase
{
    public static function assertJsonSerialization(?Session $session, ?stdClass $json): void
    {
        if ($session === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($session->getCountryCode(), $json->country_code);
            Assert::assertSame($session->getPartyId(), $json->party_id);
            Assert::assertSame($session->getId(), $json->id);
            Assert::assertSame(DateTimeFormatter::format($session->getStartDateTime()), $json->start_date_time);

            if (is_null($json->end_date_time ?? null)) {
                Assert::assertNull($session->getEndDateTime());
            } else {
                Assert::assertSame(DateTimeFormatter::format($session->getEndDateTime()), $json->end_date_time);
            }

            Assert::assertEquals($session->getKwh(), $json->kwh);
            CdrTokenTest::assertJsonSerialization($session->getCdrToken(), $json->cdr_token);
            Assert::assertSame($session->getAuthMethod()->getValue(), $json->auth_method);
            Assert::assertSame($session->getAuthorizationReference(), $json->authorization_reference);
            Assert::assertSame($session->getLocationId(), $json->location_id);
            Assert::assertSame($session->getEvseUid(), $json->evse_uid);
            Assert::assertSame($session->getConnectorId(), $json->connector_id);
            Assert::assertSame($session->getMeterId(), $json->meter_id ?? null);
            Assert::assertSame($session->getCurrency(), $json->currency);
            Assert::assertCount(count($session->getChargingPeriods()), $json->charging_periods);
            foreach ($session->getChargingPeriods() as $index => $chargingPeriod) {
                ChargingPeriodTest::assertJsonSerialization($chargingPeriod, $json->charging_periods[$index]);
            }
            PriceTest::assertJsonSerialization($session->getTotalCost(), $json->total_cost);
            Assert::assertSame($session->getStatus()->getValue(), $json->status);
            Assert::assertSame(DateTimeFormatter::format($session->getLastUpdated()), $json->last_updated);
        }
    }

    public function pathAndPropertyProvider(): array
    {
        return [
            'id' => [__DIR__ . '/Payloads/Sessions/SessionPatchIdPayload.json', 'getId'],
            'start date' => [__DIR__ . '/Payloads/Sessions/SessionPatchStartDatetimePayload.json', 'getStartDateTime'],
            'end date' => [__DIR__ . '/Payloads/Sessions/SessionPatchEndDatetimePayload.json', 'getEndDateTime'],
            'kwh' => [__DIR__ . '/Payloads/Sessions/SessionPatchKwhPayload.json', 'getKwh'],
            'cdr token' => [__DIR__ . '/Payloads/Sessions/SessionPatchCdrTokenPayload.json', 'getCdrToken'],
            'auth method' => [__DIR__ . '/Payloads/Sessions/SessionPatchAuthMethodPayload.json', 'getAuthMethod'],
            'location_id' => [__DIR__ . '/Payloads/Sessions/SessionPatchLocationPayload.json', 'getLocationId'],
            'meter id' => [__DIR__ . '/Payloads/Sessions/SessionPatchMeterIdPayload.json', 'getMeterId'],
            'currency' => [__DIR__ . '/Payloads/Sessions/SessionPatchCurrencyPayload.json', 'getCurrency'],
            'total cost' => [__DIR__ . '/Payloads/Sessions/SessionPatchTotalCostPayload.json', 'getTotalCost'],
            'status' => [__DIR__ . '/Payloads/Sessions/SessionPatchStatusPayload.json', 'getStatus'],
            'last update' => [__DIR__ . '/Payloads/Sessions/SessionPatchLastUpdatedPayload.json', 'getLastUpdated'],
            'charging periods' => [
                __DIR__ . '/Payloads/Sessions/SessionPatchChargingPeriodsPayload.json',
                'getChargingPeriods'
            ],
        ];
    }

    /**
     * @dataProvider pathAndPropertyProvider
     * @param string $path
     * @param string $accessor
     */
    public function testShouldCorrectlyMergeWithPartialSession(string $path, string $accessor): void
    {
        $session = SessionFactory::fromJson(json_decode(file_get_contents(__DIR__ . '/Payloads/Sessions/SessionPutPayload.json')));
        $partialSession = PartialSessionFactory::fromJson(json_decode(file_get_contents($path)));

        $newSession = $session->merge($partialSession);
        $this->assertSame($partialSession->$accessor(), $newSession->$accessor());
    }

    public function getDumbSession(): Session
    {
        return new Session(
            'FR',
            'FRA',
            'id1',
            (new DateTime())->setTimestamp(123456789),
            (new DateTime())->setTimestamp(918273645),
            22.345,
            new CdrToken('FR', 'FRA', 'user1', TokenType::AD_HOC_USER(), 'contract1'),
            AuthMethod::AUTH_REQUEST(),
            'ref1',
            'location1',
            'evse1',
            'connector1',
            'meterId1',
            'currency1',
            new Price(50.123, null),
            SessionStatus::PENDING(),
            (new DateTime())->setTimestamp(11111111),
        );
    }

    public function periodsDiffTestProvider(): iterable
    {
        yield 'both has no charging periods' => [[], [], null];

        $startDate1 = (new DateTime())->setTimestamp(123456789);
        $startDate2 = (new DateTime())->setTimestamp(987654321);

        $chargingPeriod = new ChargingPeriod($startDate1, null);
        $chargingPeriod->addDimension(new CdrDimension(CdrDimensionType::TIME(), 0.5));

        yield 'both has same charging period with one dimension' => [[$chargingPeriod], [$chargingPeriod], null];

        $chargingPeriod2 = new ChargingPeriod($startDate2, null);
        $chargingPeriod2->addDimension(new CdrDimension(CdrDimensionType::ENERGY(), 1231.134));

        yield 'both has same charging periods with one dimension' => [
            [$chargingPeriod, $chargingPeriod2],
            [$chargingPeriod, $chargingPeriod2],
            null
        ];

        $chargingPeriod = new ChargingPeriod($startDate1, "tariff#1");
        $chargingPeriod->addDimension(new CdrDimension(CdrDimensionType::TIME(), 0.5));
        $chargingPeriod->addDimension(new CdrDimension(CdrDimensionType::MAX_CURRENT(), 0.23423));

        $chargingPeriod2 = new ChargingPeriod($startDate2, "tariff2");
        $chargingPeriod2->addDimension(new CdrDimension(CdrDimensionType::ENERGY(), 1231.134));
        $chargingPeriod2->addDimension(new CdrDimension(CdrDimensionType::TIME(), 2342.234));
        yield 'both has same charging periods with multiple dimensions' => [
            [$chargingPeriod, $chargingPeriod2],
            [$chargingPeriod, $chargingPeriod2],
            null
        ];

        yield 'both has same charging periods with multiple dimensions added in different order' => [
            [$chargingPeriod2, $chargingPeriod],
            [$chargingPeriod, $chargingPeriod2],
            null
        ];

        yield 'first session has no period' => [
            [],
            [$chargingPeriod, $chargingPeriod2],
            [$chargingPeriod, $chargingPeriod2],
        ];

        yield 'second session has no period' => [
            [$chargingPeriod, $chargingPeriod2],
            [],
            []
        ];

        $chargingPeriod = new ChargingPeriod($startDate1, null);
        $chargingPeriod->addDimension(new CdrDimension(CdrDimensionType::TIME(), 0.5));

        $chargingPeriodModified = new ChargingPeriod($startDate1, null);
        $chargingPeriodModified->addDimension(new CdrDimension(CdrDimensionType::TIME(), 1.0));

        yield 'second session has changed a dimension volume' => [
            [$chargingPeriod],
            [$chargingPeriodModified],
            [$chargingPeriodModified]
        ];

        $chargingPeriodModified = new ChargingPeriod($startDate1, null);
        $chargingPeriodModified->addDimension(new CdrDimension(CdrDimensionType::TIME(), 0.5));
        $chargingPeriodModified->addDimension(new CdrDimension(CdrDimensionType::MAX_CURRENT(), 0.23423));

        yield 'second session has added a dimension to the period' => [
            [$chargingPeriod],
            [$chargingPeriodModified],
            [$chargingPeriodModified]
        ];

        yield 'second session has deleted a dimension from the period' => [
            [$chargingPeriodModified],
            [$chargingPeriod],
            [$chargingPeriod]
        ];

        yield 'second session has added one more period' => [
            [$chargingPeriod],
            [$chargingPeriod, $chargingPeriod2],
            [$chargingPeriod2]
        ];

        $chargingPeriod2 = new ChargingPeriod($startDate2, null);
        $chargingPeriod2->addDimension(new CdrDimension(CdrDimensionType::TIME(), 1.0));

        yield 'second session has modified first period and added one more' => [
            [$chargingPeriod],
            [$chargingPeriodModified, $chargingPeriod2],
            [$chargingPeriodModified, $chargingPeriod2]
        ];
    }

    /**
     * @dataProvider periodsDiffTestProvider
     * @param array $chargingPeriods1
     * @param array $chargingPeriods2
     * @param array|null $expectation
     */
    public function testChargingPeriodsDiff(
        array $chargingPeriods1,
        array $chargingPeriods2,
        ?array $expectation
    ): void {
        $session1 = $this->getDumbSession();
        foreach ($chargingPeriods1 as $chargingPeriod) {
            $session1->addChargingPeriod($chargingPeriod);
        }
        $session2 = $this->getDumbSession();
        foreach ($chargingPeriods2 as $chargingPeriod) {
            $session2->addChargingPeriod($chargingPeriod);
        }

        $diff = Session::chargingPeriodsDiff($session1, $session2);
        $this->assertSame($expectation, $diff);
    }

    public function diffTestProvider(): iterable
    {
        $countryCode1 = 'FR';
        $countryCode2 = 'BE';
        $partyId1 = 'FRA';
        $partyId2 = 'BEL';
        $id1 = 'id1';
        $id2 = 'id2';
        $startDate1 = (new DateTime())->setTimestamp(123456789);
        $startDate2 = (new DateTime())->setTimestamp(987654321);
        $endDate1 = (new DateTime())->setTimestamp(918273645);
        $endDate2 = (new DateTime())->setTimestamp(564738291);
        $kwh1 = 22.345;
        $kwh2 = 55.132;
        $cdrToken1 = new CdrToken('FRA', 'FR', 'user1', TokenType::AD_HOC_USER(), 'contract1');
        $cdrToken2 = new CdrToken('BEL', 'BL', 'user2', TokenType::APP_USER(), 'contract2');
        $authMethod1 = AuthMethod::AUTH_REQUEST();
        $authMethod2 = AuthMethod::WHITELIST();
        $authorizationReference1 = 'ref1';
        $authorizationReference2 = 'ref2';
        $location1 = 'location1';
        $location2 = 'location2';
        $evseUid1 = 'evse1';
        $evseUid2 = 'evse2';
        $connectorId1 = 'connectorId1';
        $connectorId2 = 'connectorId2';
        $meterId1 = 'meterId1';
        $meterId2 = 'meterId2';
        $currency1 = 'EUR';
        $currency2 = 'USD';
        $totalCost1 = new Price(50.123, 52.234);
        $totalCost2 = new Price(12.543, 15.123);
        $status1 = SessionStatus::PENDING();
        $status2 = SessionStatus::ACTIVE();
        $lastUpdated1 = (new DateTime())->setTimestamp(11111111);
        $lastUpdated2 = (new DateTime())->setTimestamp(22222222);

        $session1 = new Session(
            $countryCode1,
            $partyId1,
            $id1,
            $startDate1,
            $endDate1,
            $kwh1,
            $cdrToken1,
            $authMethod1,
            $authorizationReference1,
            $location1,
            $evseUid1,
            $connectorId1,
            $meterId1,
            $currency1,
            $totalCost1,
            $status1,
            $lastUpdated1,
        );

        $session2 = new Session(
            $countryCode1,
            $partyId1,
            $id1,
            $startDate1,
            $endDate1,
            $kwh1,
            $cdrToken1,
            $authMethod1,
            $authorizationReference1,
            $location1,
            $evseUid1,
            $connectorId1,
            $meterId1,
            $currency1,
            $totalCost1,
            $status1,
            $lastUpdated1,
        );
        yield 'no difference' => [
            'first' => $session1,
            'second' => $session2,
            'hassersWithExpectation' => [],
            'accessorsWithExpectation' => []
        ];

        $session2 = new Session(
            $countryCode2,
            $partyId2,
            $id2,
            $startDate2,
            $endDate2,
            $kwh2,
            $cdrToken2,
            $authMethod2,
            $authorizationReference2,
            $location2,
            $evseUid2,
            $connectorId2,
            $meterId2,
            $currency2,
            $totalCost2,
            $status2,
            $lastUpdated2,
        );
        $session2->addChargingPeriod($this->createMock(ChargingPeriod::class));

        yield 'full difference' => [
            'first' => $session1,
            'second' => $session2,
            'hassersWithExpectation' => [
                'hasCountryCode' => true,
                'hasPartyId' => true,
                'hasId' => true,
                'hasStartDateTime' => true,
                'hasEndDateTime' => true,
                'hasKwh' => true,
                'hasCdrToken' => true,
                'hasAuthMethod' => true,
                'hasAuthorizationReference' => true,
                'hasLocationId' => true,
                'hasEvseUid' => true,
                'hasConnectorId' => true,
                'hasMeterId' => true,
                'hasCurrency' => true,
                'hasChargingPeriods' => true,
                'hasTotalCost' => true,
                'hasStatus' => true,
                'hasLastUpdated' => true,
            ],
            'accessorsWithExpectation' => [
                'getCountryCode' => $session2->getCountryCode(),
                'getPartyId' => $session2->getPartyId(),
                'getId' => $session2->getId(),
                'getStartDateTime' => $session2->getStartDateTime(),
                'getEndDateTime' => $session2->getEndDateTime(),
                'getKwh' => $session2->getKwh(),
                'getCdrToken' => $session2->getCdrToken(),
                'getAuthMethod' => $session2->getAuthMethod(),
                'getAuthorizationReference' => $session2->getAuthorizationReference(),
                'getLocationId' => $session2->getLocationId(),
                'getEvseUid' => $session2->getEvseUid(),
                'getConnectorId' => $session2->getConnectorId(),
                'getMeterId' => $session2->getMeterId(),
                'getCurrency' => $session2->getCurrency(),
                'getTotalCost' => $session2->getTotalCost(),
                'getStatus' => $session2->getStatus(),
                'getLastUpdated' => $session2->getLastUpdated(),
                'getChargingPeriods' => $session2->getChargingPeriods()
            ]
        ];

        $session2 = new Session(
            $countryCode1,
            $partyId1,
            $id2,
            $startDate1,
            $endDate1,
            $kwh1,
            $cdrToken1,
            $authMethod1,
            $authorizationReference1,
            $location1,
            $evseUid1,
            $connectorId1,
            $meterId1,
            $currency1,
            $totalCost1,
            $status1,
            $lastUpdated1,
        );

        yield 'id only' => [
            'first' => $session1,
            'second' => $session2,
            'hassersWithExpectation' => [
                'hasCountryCode' => false,
                'hasPartyId' => false,
                'hasId' => true,
                'hasStartDateTime' => false,
                'hasEndDateTime' => false,
                'hasKwh' => false,
                'hasCdrToken' => false,
                'hasAuthMethod' => false,
                'hasAuthorizationReference' => false,
                'hasLocation' => false,
                'hasEvseUid' => false,
                'hasConnectorId' => false,
                'hasMeterId' => false,
                'hasCurrency' => false,
                'hasChargingPeriods' => false,
                'hasTotalCost' => false,
                'hasStatus' => false,
                'hasLastUpdated' => false,
            ],
            'accessorsWithExpectation' => [
                'getId' => $session2->getId()
            ]
        ];

        $session1 = new Session(
            $countryCode1,
            $partyId1,
            $id1,
            $startDate1,
            null,
            $kwh1,
            $cdrToken1,
            $authMethod1,
            $authorizationReference1,
            $location1,
            $evseUid1,
            $connectorId1,
            $meterId1,
            $currency1,
            $totalCost1,
            $status1,
            $lastUpdated1,
        );

        $session2 = new Session(
            $countryCode1,
            $partyId1,
            $id1,
            $startDate1,
            $endDate2,
            $kwh2,
            $cdrToken1,
            $authMethod1,
            $authorizationReference1,
            $location1,
            $evseUid1,
            $connectorId1,
            $meterId1,
            $currency1,
            $totalCost2,
            $status1,
            $lastUpdated2,
        );

        yield 'most important params' => [
            'first' => $session1,
            'second' => $session2,
            'hassersWithExpectation' => [
                'hasCountryCode' => false,
                'hasPartyId' => false,
                'hasId' => false,
                'hasStartDateTime' => false,
                'hasEndDateTime' => true,
                'hasKwh' => true,
                'hasCdrToken' => false,
                'hasAuthMethod' => false,
                'hasAuthorizationReference' => false,
                'hasLocation' => false,
                'hasEvseUid' => false,
                'hasConnectorId' => false,
                'hasMeterId' => false,
                'hasCurrency' => false,
                'hasChargingPeriods' => false,
                'hasTotalCost' => true,
                'hasStatus' => false,
                'hasLastUpdated' => true,
            ],
            'accessorsWithExpectation' => [
                'getEndDateTime' => $session2->getEndDateTime(),
                'getKwh' => $session2->getKwh(),
                'getTotalCost' => $session2->getTotalCost(),
                'getLastUpdated' => $session2->getLastUpdated()
            ]
        ];

        $session1 = new Session(
            $countryCode1,
            $partyId1,
            $id1,
            $startDate1,
            null,
            $kwh1,
            $cdrToken1,
            $authMethod1,
            $authorizationReference1,
            $location1,
            $evseUid1,
            $connectorId1,
            $meterId1,
            $currency1,
            $totalCost1,
            $status1,
            $lastUpdated1,
        );

        $chargingPeriod = new ChargingPeriod($startDate1, null);
        $chargingPeriod->addDimension(new CdrDimension(CdrDimensionType::TIME(), 0.5));

        $session1->addChargingPeriod($chargingPeriod);

        $session2 = new Session(
            $countryCode1,
            $partyId1,
            $id1,
            $startDate1,
            null,
            $kwh1,
            $cdrToken1,
            $authMethod1,
            $authorizationReference1,
            $location1,
            $evseUid1,
            $connectorId1,
            $meterId1,
            $currency1,
            $totalCost1,
            $status1,
            $lastUpdated1,
        );

        $chargingPeriodModified = new ChargingPeriod($startDate1, null);
        $chargingPeriodModified->addDimension(new CdrDimension(CdrDimensionType::TIME(), 1.0));
        $chargingPeriod2 = new ChargingPeriod($startDate2, null);
        $chargingPeriod2->addDimension(new CdrDimension(CdrDimensionType::TIME(), 1.0));

        $session2->addChargingPeriod($chargingPeriodModified);
        $session2->addChargingPeriod($chargingPeriod2);

        yield 'charging periods' => [
            'first' => $session1,
            'second' => $session2,
            'hassersWithExpectation' => [
                'hasCountryCode' => false,
                'hasPartyId' => false,
                'hasId' => false,
                'hasStartDateTime' => false,
                'hasEndDateTo,e' => false,
                'hasKwh' => false,
                'hasCdrToken' => false,
                'hasAuthMethod' => false,
                'hasAuthorizationReference' => false,
                'hasLocation' => false,
                'hasEvseUid' => false,
                'hasConnectorId' => false,
                'hasMeterId' => false,
                'hasCurrency' => false,
                'hasChargingPeriods' => true,
                'hasTotalCost' => false,
                'hasStatus' => false,
                'hasLastUpdated' => false,
            ],
            'accessorsWithExpectation' => [
                'getChargingPeriods' => Session::chargingPeriodsDiff($session1, $session2),
            ]
        ];

    }

    /**
     * @dataProvider diffTestProvider
     * @param \Chargemap\OCPI\Versions\V2_2_1\Common\Models\Session $first
     * @param \Chargemap\OCPI\Versions\V2_2_1\Common\Models\Session $second
     * @param array<string, bool> $hassersWithExpectation
     * @param array<string, mixed> $accessorsWithExpectation
     */
    public function testShouldReturnCorrectDiff(
        Session $first,
        Session $second,
        array $hassersWithExpectation,
        array $accessorsWithExpectation
    ): void {
        $diff = $first->diff($second);
        if (empty($hassersWithExpectation)) {
            $this->assertNull($diff);
        }
        foreach ($hassersWithExpectation as $hasser => $expectation) {
            $this->assertSame($expectation, $diff->$hasser(), "$hasser is not " . ($expectation ? 'true' : 'false'));
        }
        foreach ($accessorsWithExpectation as $accessor => $expectation) {
            $this->assertSame($expectation, $diff->$accessor());
        }
    }
}
