<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Models\AllowedType;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\AuthorizationInfo;
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
            LocationReferencesFactory::fromJson(($json->location ?? null)),
            DisplayTextFactory::fromJson($json->info ?? null)
        );
    }
}
