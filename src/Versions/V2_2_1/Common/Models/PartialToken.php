<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Common\Utils\PartialModel;
use DateTime;
use JsonSerializable;

class PartialToken extends PartialModel implements JsonSerializable
{
    private ?string $countryCode;

    private ?string $partyId;

    private ?string $uid;

    private ?TokenType $type;

    private ?string $contractId;

    private ?string $visualNumber;

    private ?string $issuer;

    private ?bool $valid;

    private ?string $groupId;

    private ?WhiteListType $whiteList;

    private ?string $language;

    private ?ProfileType $defaultProfileType;

    private ?EnergyContract $energyContract;

    private ?DateTime $lastUpdated;

    public function _withCountryCode(string $countryCode) {
        $this->countryCode = $countryCode;
    }

    public function _withPartyId(string $partyId) {
        $this->partyId = $partyId;
    }

    public function _withUid(string $uid) {
        $this->uid = $uid;
    }

    public function _withType(TokenType $type) {
        $this->type = $type;
    }

    public function _withContractId(string $contractId) {
        $this->contractId = $contractId;
    }

    public function _withVisualNumber(?string $visualNumber) {
        $this->visualNumber = $visualNumber;
    }

    public function _withIssuer(string $issuer) {
        $this->issuer = $issuer;
    }

    public function _withGroupId(?string $groupId) {
        $this->groupId = $groupId;
    }

    public function _withValid(bool $valid) {
        $this->valid = $valid;
    }

    public function _withWhiteList(WhiteListType $whiteList) {
        $this->whiteList = $whiteList;
    }

    public function _withLanguage(?string $language) {
        $this->language = $language;
    }

    public function _withDefaultProfileType(?ProfileType $defaultProfileType) {
        $this->defaultProfileType = $defaultProfileType;
    }

    public function _withEnergyContract(?EnergyContract $energyContract) {
        $this->energyContract = $energyContract;
    }

    public function _withLastUpdated(\DateTime $lastUpdated) {
        $this->lastUpdated = $lastUpdated;
    }

    public function getCountryCode(): ?string {
        return $this->countryCode;
    }

    public function getPartyId(): ?string {
        return $this->partyId;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function getType(): ?TokenType
    {
        return $this->type;
    }

    public function getContractId(): ?string
    {
        return $this->contractId;
    }

    public function getVisualNumber(): ?string
    {
        return $this->visualNumber;
    }

    public function getIssuer(): ?string
    {
        return $this->issuer;
    }

    public function getGroupId(): ?string
    {
        return $this->groupId;
    }

    public function isValid(): ?bool
    {
        return $this->valid;
    }

    public function getWhiteList(): ?WhiteListType
    {
        return $this->whiteList;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function getDefaultProfileType(): ?ProfileType
    {
        return $this->defaultProfileType;
    }

    public function getEnergyContract(): EnergyContract
    {
        return $this->energyContract;
    }

    public function getLastUpdated(): ?DateTime
    {
        return $this->lastUpdated;
    }

    public function jsonSerialize(): array
    {
        $return = [];
        
        if($this->hasCountryCode()){
            $return['country_code'] = $this->countryCode;
        }

        if($this->hasPartyId()){
            $return['party_id'] = $this->partyId;
        }

        if($this->hasUid()){
            $return['uid'] = $this->uid;
        }
        
        if($this->hasType()){
            $return['type'] = $this->type;
        }

        if($this->hasContractId()){
            $return['contract_id'] = $this->contractId;
        }
        
        if($this->hasIssuer()){
            $return['issuer'] = $this->issuer;
        }

        if($this->hasGroupId()){
            $return['group_id'] = $this->groupId;
        }
        
        if($this->hasValid()){
            $return['valid'] = $this->valid;
        }
        if($this->hasWhiteList()){
            $return['whitelist'] = $this->whiteList;
        }
        
        if($this->hasLastUpdated()){
            $return['last_updated'] = DateTimeFormatter::format($this->lastUpdated);
        }
        
        if ($this->hasVisualNumber()) {
            $return['visual_number'] = $this->visualNumber;
        }

        if ($this->hasEnergyContract()){
            $return['energy_contract'] = $this->energyContract;
        }

        if ($this->hasLanguage()) {
            $return['language'] = $this->language;
        }

        return $return;
    }
}
