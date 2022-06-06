<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use JsonSerializable;

class CdrToken implements JsonSerializable
{
    private string $countryCode;

    private string $partyId;

    private string $uid;

    private TokenType $type;

    private string $contractId;

    public function __construct(
        string $countryCode,
        string $partyId,
        string $uid,
        TokenType $type,
        string $contractId
    )
    {
        $this->countryCode = $countryCode;
        $this->partyId = $partyId;
        $this->uid = $uid;
        $this->type = $type;
        $this->contractId = $contractId;
    }

    public function getCountryCode(): string {
        return $this->countryCode;
    }

    public function getPartyId(): string {
        return $this->partyId;
    }

    public function getUid(): string {
        return $this->uid;
    }

    public function getType(): TokenType {
        return $this->type;
    }

    public function getContractId(): string {
        return $this->contractId;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'country_code' => $this->countryCode,
            'party_id' => $this->partyId,
            'uid' => $this->uid,
            'type' => $this->type,
            'contract_id' => $this->contractId,
        ];

        return $return;
    }
}
