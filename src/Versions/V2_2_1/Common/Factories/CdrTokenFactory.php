<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CdrToken;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\TokenType;
use stdClass;

class CdrTokenFactory
{
    public static function fromJson(?stdClass $json): ?CdrToken
    {
        if ($json === null) {
            return null;
        }

        return new CdrToken(
            $json->country_code,
            $json->party_id,
            $json->uid,
            TokenType::from($json->type),
            $json->contract_id
        );
    }
}
