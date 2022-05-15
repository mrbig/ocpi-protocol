<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\AllowedType;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\AuthorizationInfo;
use stdClass;

class AuthorizationInfoFactory
{
    public static function fromJson(?stdClass $json): ?AuthorizationInfo
    {
        if ($json === null) {
            return null;
        }

        return new AuthorizationInfo(
            AllowedType::from($json->allowed),
            TokenFactory::fromJson($json->token),
            LocationReferencesFactory::fromJson(($json->location ?? null)),
            $json->authorization_reference ?? null,
            DisplayTextFactory::fromJson($json->info ?? null)
        );
    }
}
