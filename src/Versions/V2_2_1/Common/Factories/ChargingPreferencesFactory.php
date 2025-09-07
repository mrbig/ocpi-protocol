<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ChargingPreferences;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ProfileType;
use DateTime;
use stdClass;

class ChargingPreferencesFactory
{
    public static function fromJson(?stdClass $json): ?ChargingPreferences
    {
        if ($json === null) {
            return null;
        }

        $preferences = new ChargingPreferences(
            new ProfileType($json->profile_type),
            !empty($json->departure_time) ? new DateTime($json->departure_time) : null,
            $json->energy_needed ?? null,
            $json->discharge_allowed ?? null
        );

        return $preferences;
    }
}
