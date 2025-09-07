<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ConnectorType;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CdrLocation;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ConnectorFormat;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\PowerType;
use stdClass;

class CdrLocationFactory
{
    public static function fromJson(?stdClass $json): ?CdrLocation
    {
        if ($json === null) {
            return null;
        }

        $location = new CdrLocation(
            $json->id,
            $json->name ?? null,
            $json->address,
            $json->city,
            $json->postal_code ?? null,
            $json->state ?? null,
            $json->country,
            GeoLocationFactory::fromJson($json->coordinates),
            $json->evse_uid,
            $json->evse_id,
            $json->connector_id,
            new ConnectorType($json->connector_standard),
            new ConnectorFormat($json->connector_format),
            new PowerType($json->connector_power_type)
        );

        return $location;
    }
}
