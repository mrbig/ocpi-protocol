<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\AuthMethod;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\PartialSession;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\SessionStatus;
use DateTime;
use stdClass;

class PartialSessionFactory
{
    public static function fromJson(?stdClass $json): ?PartialSession
    {
        if ($json === null) {
            return null;
        }

        $session = new PartialSession();

        if (property_exists($json, 'country_code')) {
            $session->withCountryCode($json->country_code);
        }
        if (property_exists($json, 'party_id')) {
            $session->withPartyId($json->party_id);
        }
        if (property_exists($json, 'id')) {
            $session->withId($json->id);
        }
        if (property_exists($json, 'start_date_time')) {
            $session->withStartDateTime(new DateTime($json->start_date_time));
        }
        if (property_exists($json, 'end_date_time')) {
            $session->withEndDateTime(new DateTime($json->end_date_time));
        }
        if (property_exists($json, 'kwh')) {
            $session->withKwh($json->kwh);
        }
        if (property_exists($json, 'cdr_token')) {
            $session->withCdrToken(CdrTokenFactory::fromJson($json->cdr_token));
        }
        if (property_exists($json, 'auth_method')) {
            $session->withAuthMethod(new AuthMethod($json->auth_method));
        }
        if (property_exists($json, 'authorization_reference')) {
            $session->withAuthorizationReference($json->authorization_reference);
        }
        if (property_exists($json, 'location_id')) {
            $session->withLocationId($json->location_id);
        }
        if (property_exists($json, 'evse_uid')) {
            $session->withEvseUid($json->evse_uid);
        }
        if (property_exists($json, 'connector_id')) {
            $session->withConnectorId($json->connector_id);
        }
        if (property_exists($json, 'meter_id')) {
            $session->withMeterId($json->meter_id);
        }
        if (property_exists($json, 'currency')) {
            $session->withCurrency($json->currency);
        }
        if (property_exists($json, 'total_cost')) {
            $session->withTotalCost(PriceFactory::fromJson($json->total_cost));
        }
        if (property_exists($json, 'status')) {
            $session->withStatus(new SessionStatus($json->status));
        }
        if (property_exists($json, 'last_updated')) {
            $session->withLastUpdated(new DateTime($json->last_updated));
        }
        if (property_exists($json, 'charging_periods')) {
            $session->withChargingPeriods();
            foreach (ChargingPeriodFactory::arrayFromJsonArray($json->charging_periods) ?? [] as $chargingPeriod) {
                $session->withChargingPeriod($chargingPeriod);
            }
        }

        return $session;
    }
}