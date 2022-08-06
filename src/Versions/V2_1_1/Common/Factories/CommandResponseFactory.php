<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CommandResponse;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CommandResponseType;
use stdClass;

class CommandResponseFactory
{
    public static function fromJson(?stdClass $json): ?CommandResponse
    {
        if ($json === null) {
            return null;
        }

        $response = new CommandResponse(
            CommandResponseType::from($json->result)
        );

        return $response;
    }
}
