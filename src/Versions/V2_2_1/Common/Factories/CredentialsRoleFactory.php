<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CredentialsRole;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Role;
use stdClass;

class CredentialsRoleFactory
{
	public static function fromJson(?stdClass $json): ?CredentialsRole
	{
		if ($json === null) {
			return null;
		}

		return new CredentialsRole(
			new Role($json->role),
			BusinessDetailsFactory::fromJson($json->business_details),
			$json->party_id,
			$json->country_code
		);
	}
}
