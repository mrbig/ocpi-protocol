<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Common\Utils\PartialModel;

use DateTime;
use JsonSerializable;

class PartialToken extends PartialModel implements JsonSerializable
{
    private ?string $uid;

    private ?TokenType $type;

    private ?string $authId;

    private ?string $visualNumber;

    private ?string $issuer;

    private ?bool $valid;

    private ?WhiteList $whiteList;

    private ?string $language;

    private ?DateTime $lastUpdated;

    public function _withUid(string $uid) {
        $this->uid = $uid;
    }

    public function _withType(TokenType $type) {
        $this->type = $type;
    }

    public function _withAuthId(string $authId) {
        $this->authId = $authId;
    }

    public function _withVisualNumber(?string $visualNumber) {
        $this->visualNumber = $visualNumber;
    }

    public function _withIssuer(string $issuer) {
        $this->issuer = $issuer;
    }

    public function _withValid(bool $valid) {
        $this->valid = $valid;
    }

    public function _withWhiteList(WhiteList $whiteList) {
        $this->whiteList = $whiteList;
    }

    public function _withLanguage(?string $language) {
        $this->language = $language;
    }

    public function _withLastUpdated(\DateTime $lastUpdated) {
        $this->lastUpdated = $lastUpdated;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function getType(): ?TokenType
    {
        return $this->type;
    }

    public function getAuthId(): ?string
    {
        return $this->authId;
    }

    public function getVisualNumber(): ?string
    {
        return $this->visualNumber;
    }

    public function getIssuer(): ?string
    {
        return $this->issuer;
    }

    public function isValid(): ?bool
    {
        return $this->valid;
    }

    public function getWhiteList(): ?WhiteList
    {
        return $this->whiteList;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function getLastUpdated(): ?DateTime
    {
        return $this->lastUpdated;
    }

    public function jsonSerialize(): array
    {
        $return = [];
        
        if($this->hasUid()){
            $return['uid'] = $this->uid;
        }
        
        if($this->hasType()){
            $return['type'] = $this->type;
        }

        if($this->hasAuthId()){
            $return['auth_id'] = $this->authId;
        }
        
        if($this->hasIssuer()){
            $return['issuer'] = $this->issuer;
        }

        if($this->hasValid()){
            $return['valid'] = $this->valid;
        }
        if($this->hasWhiteList()){
            $return['whitelist'] = $this->whiteList;
        }
        
        if ($this->hasLanguage()) {
            $return['language'] = $this->language;
        }

        if($this->hasLastUpdated()){
            $return['last_updated'] = DateTimeFormatter::format($this->lastUpdated);
        }
        
        if ($this->hasVisualNumber()) {
            $return['visual_number'] = $this->visualNumber;
        }

        return $return;
    }
}
