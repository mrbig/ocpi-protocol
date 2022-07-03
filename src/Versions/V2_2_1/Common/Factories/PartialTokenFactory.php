<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\PartialToken;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\TokenType;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\WhiteListType;
use DateTime;
use stdClass;

class PartialTokenFactory
{
    public static function fromJson(?stdClass $json): ?PartialToken
    {
        if ($json === null) {
            return null;
        }

        $token = new PartialToken(
            $json->country_code ?? null,
            $json->party_id ?? null,
            $json->uid ?? null,
            property_exists($json, 'type') ? new TokenType($json->type) : null,
            $json->contract_id ?? null,
            $json->visual_number ?? null,
            $json->issuer ?? null,
            $json->group_id ?? null,
            $json->valid ?? null,
            property_exists($json, 'whitelist') ? new WhiteListType($json->whitelist) : null,
            $json->language ?? null,
            EnergyContractFactory::fromJson($json->energy_contract ?? null),
            property_exists($json, 'last_updated') ? new DateTime($json->last_updated) : null
        );

        return $token;
    }
}