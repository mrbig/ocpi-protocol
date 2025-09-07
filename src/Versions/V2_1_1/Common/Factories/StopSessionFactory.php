<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\StopSession;
use stdClass;

class StopSessionFactory
{
    public static function fromJson(?stdClass $json): ?StopSession
    {
        if ($json === null) {
            return null;
        }

        return new StopSession(
            $json->response_url,
            $json->session_id
        );
    }
}
