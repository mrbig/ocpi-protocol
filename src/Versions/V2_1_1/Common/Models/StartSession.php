<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

class StartSession extends Command
{

    private string $responseUrl;
    private Token $token;
    private string $locationId;
    private ?string $evseUid;

    public function __construct(
        string $responseUrl,
        Token $token,
        string $locationId,
        ?string $evseUid
    )
    {
        $this->responseUrl = $responseUrl;
        $this->token = $token;
        $this->locationId = $locationId;
        $this->evseUid = $evseUid;
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
}