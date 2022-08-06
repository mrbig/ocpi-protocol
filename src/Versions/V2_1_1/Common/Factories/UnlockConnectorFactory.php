<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\UnlockConnector;
use stdClass;

class UnlockConnectorFactory
{
    public static function fromJson(?stdClass $json): ?UnlockConnector
    {
        if ($json === null) {
            return null;
        }

        return new UnlockConnector(
            $json->response_url,
            $json->location_id,
            $json->evse_uid,
            $json->connector_id
        );
    }
}
