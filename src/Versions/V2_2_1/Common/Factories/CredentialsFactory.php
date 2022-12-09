<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Credentials;
use stdClass;

class CredentialsFactory
{
    public static function fromJson(?stdClass $json): ?Credentials
    {
        if ($json === null) {
            return null;
        }

        $credentials = new Credentials(
            $json->token,
            $json->url,
        );

        if (property_exists($json, 'roles') && $json->roles !== null) {
            foreach ($json->roles as $role) {
                $credentials->addRole(CredentialsRoleFactory::fromJson($role));
            }
        }

        return $credentials;
    }
}
