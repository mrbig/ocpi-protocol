<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class Token implements JsonSerializable
{
    private string $countryCode;

    private string $partyId;

    private string $uid;

    private TokenType $type;

    private string $contractId;

    private ?string $visualNumber;

    private string $issuer;

    private ?string $groupId;

    private bool $valid;

    private WhiteList $whiteList;

    private ?string $language;

    private ?EnergyContract $energyContract;

    private DateTime $lastUpdated;

    public function __construct(
        string $countryCode,
        string $partyId,
        string $uid,
        TokenType $type,
        string $contractId,
        ?string $visualNumber,
        string $issuer,
        ?string $groupId,
        bool $valid,
        WhiteList $whiteList,
        ?string $language,
        ?EnergyContract $energyContract,
        DateTime $lastUpdated)
    {
        $this->countryCode = $countryCode;
        $this->partyId = $partyId;
        $this->uid = $uid;
        $this->type = $type;
        $this->contractId = $contractId;
        $this->visualNumber = $visualNumber;
        $this->issuer = $issuer;
        $this->groupId = $groupId;
        $this->valid = $valid;
        $this->whiteList = $whiteList;
        $this->language = $language;
        $this->energyContract = $energyContract;
        $this->lastUpdated = $lastUpdated;
    }

    public function getCountryCode(): string {
        return $this->countryCode;
    }

    public function getPartyId(): string {
        return $this->partyId;
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function getType(): TokenType
    {
        return $this->type;
    }

    public function getContractId(): string
    {
        return $this->contractId;
    }

    public function getVisualNumber(): ?string
    {
        return $this->visualNumber;
    }

    public function getIssuer(): string
    {
        return $this->issuer;
    }

    public function getGroupId(): ?string
    {
        return $this->groupId;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function getWhiteList(): WhiteList
    {
        return $this->whiteList;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function getEnetryContract(): ?EnergyContract
    {
        return $this->energyContract;
    }

    public function getLastUpdated(): DateTime
    {
        return $this->lastUpdated;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'country_code' => $this->countryCode,
            'party_id' => $this->partyId,
            'uid' => $this->uid,
            'type' => $this->type,
            'contract_id' => $this->contractId,
            'issuer' => $this->issuer,
            'valid' => $this->valid,
            'whitelist' => $this->whiteList,
            'last_updated' => DateTimeFormatter::format($this->lastUpdated)
        ];

        if ($this->visualNumber !== null) {
            $return['visual_number'] = $this->visualNumber;
        }

        if ($this->groupId !== null) {
            $return['group_id'] = $this->groupId;
        }

        if ($this->language !== null) {
            $return['language'] = $this->language;
        }

        if ($this->energyContract !== null) {
            $return['energy_contract'] = $this->energyContract;
        }

        return $return;
    }
}
