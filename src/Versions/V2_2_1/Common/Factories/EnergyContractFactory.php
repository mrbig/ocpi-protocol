<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\EnergyContract;
use stdClass;

class EnergyContractFactory
{
    public static function fromJson(?stdClass $json): ?EnergyContract
    {
        if ($json === null) {
            return null;
        }

        $token = new EnergyContract(
            $json->supplier_name,
            $json->contract_id ?? null
        );

        return $token;
    }
}