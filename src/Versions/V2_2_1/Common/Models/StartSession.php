<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use JsonSerializable;

class StartSession implements JsonSerializable
{

    private string $responseUrl;
    private Token $token;
    private string $locationId;
    private ?string $evseUid;
    private ?string $connectorId;
    private ?string $authorizationReference;

    public function __construct(
        string $responseUrl,
        Token $token,
        string $locationId,
        ?string $evseUid,
        ?string $connectorId,
        ?string $authorizationReference
    )
    {
        $this->responseUrl = $responseUrl;
        $this->token = $token;
        $this->locationId = $locationId;
        $this->evseUid = $evseUid;
        $this->connectorId = $connectorId;
        $this->authorizationReference = $authorizationReference;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'response_url' => $this->responseUrl,
            'token' => $this->token,
            'location_id' => $this->locationId,
        ];

        if ($this->evseUid) {
            $return['evse_uid'] = $this->evseUid;
        }

        if ($this->connectorId) {
            $return['connector_id'] = $this->connectorId;
        }

        if ($this->authorizationReference) {
            $return['authorization_reference'] = $this->authorizationReference;
        }

        return $return;
    }

    /**
     * Get the value of responseUrl
     */ 
    public function getResponseUrl(): string
    {
        return $this->responseUrl;
    }

    /**
     * Get the value of token
     */ 
    public function getToken(): Token
    {
        return $this->token;
    }

    /**
     * Get the value of locationId
     */ 
    public function getLocationId(): string
    {
        return $this->locationId;
    }

    /**
     * Get the value of evseUid
     */ 
    public function getEvseUid(): ?string
    {
        return $this->evseUid;
    }

    /**
     * Get the value of connectorId
     */ 
    public function getConnectorId(): ?string
    {
        return $this->connectorId;
    }

    /**
     * Get the value of authorizationReference
     */ 
    public function getAuthorizationReference(): ?string
    {
        return $this->authorizationReference;
    }
}