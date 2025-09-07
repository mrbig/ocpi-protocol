<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\StartSession;
use stdClass;

class StartSessionFactory
{
    public static function fromJson(?stdClass $json): ?StartSession
    {
        if ($json === null) {
            return null;
        }

        return new StartSession(
            $json->response_url,
            TokenFactory::fromJson($json->token),
            $json->location_id,
            $json->evse_uid ?? null,
            $json->connector_id ?? null,
            $json->authorization_reference ?? null
        );
    }
}
