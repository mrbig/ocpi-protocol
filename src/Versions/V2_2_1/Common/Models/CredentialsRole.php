<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use JsonSerializable;

class CredentialsRole implements JsonSerializable
{
    private Role $role;

    private BusinessDetails $businessDetails;

    private string $partyId;

    private string $countryCode;

    public function __construct(Role $role, BusinessDetails $businessDetails, string $partyId, string $countryCode)
    {
        $this->role = $role;
        $this->businessDetails = $businessDetails;
        $this->partyId = $partyId;
        $this->countryCode = $countryCode;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function getBusinessDetails(): BusinessDetails
    {
        return $this->businessDetails;
    }

    public function getPartyId(): string
    {
        return $this->partyId;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function jsonSerialize(): array
    {
        return [
            'role' => (string)$this->role,
            'business_details' => (object)$this->businessDetails->jsonSerialize(),
            'party_id' => $this->partyId,
            'country_code' => $this->countryCode,
        ];
    }
}
