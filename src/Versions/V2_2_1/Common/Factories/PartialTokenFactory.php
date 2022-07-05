<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\EnergyContract;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\PartialToken;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ProfileType;
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

        $token = new PartialToken();

        if (property_exists($json, 'country_code')) {
            $token->withCountryCode($json->country_code);
        }
        if (property_exists($json, 'party_id')) {
            $token->withPartyId($json->party_id);
        }
        if (property_exists($json, 'uid')) {
            $token->withUid($json->uid);
        }
        if (property_exists($json, 'type')) {
            $token->withType(new TokenType($json->type));
        }
        if (property_exists($json, 'contract_id')) {
            $token->withContractId($json->contract_id);
        }
        if (property_exists($json, 'visual_number')) {
            $token->withVisualNumber($json->visual_number);
        }
        if (property_exists($json, 'issuer')) {
            $token->withIssuer($json->issuer);
        }
        if (property_exists($json, 'group_id')) {
            $token->withGroupId($json->group_id);
        }
        if (property_exists($json, 'valid')) {
            $token->withValid($json->valid);
        }
        if (property_exists($json, 'whitelist')) {
            $token->withWhiteList(new WhiteListType($json->whitelist));
        }
        if (property_exists($json, 'language')) {
            $token->withLanguage($json->language);
        }
        if (property_exists($json, 'default_profile_type')) {
            $token->withDefaultProfileType($json->default_profile_type !== null ? new ProfileType($json->default_profile_type) : null);
        }
        if (property_exists($json, 'energy_contract')) {
            $token->withEnergyContract(EnergyContractFactory::fromJson($json->energy_contract));
        }
        if (property_exists($json, 'last_updated')) {
            $token->withLastUpdated($json->last_updated ? new DateTime($json->last_updated) : null);
        }

        return $token;
    }
}