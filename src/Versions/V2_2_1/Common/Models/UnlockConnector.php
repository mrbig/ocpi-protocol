<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

class UnlockConnector extends Command
{

    private string $responseUrl;
    private string $locationId;
    private string $evseUid;
    private string $connectorId;

    public function __construct(
        string $responseUrl,
        string $locationId,
        string $evseUid,
        string $connectorId
    )
    {
        $this->responseUrl = $responseUrl;
        $this->locationId = $locationId;
        $this->evseUid = $evseUid;
        $this->connectorId = $connectorId;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'response_url' => $this->responseUrl,
            'location_id' => $this->locationId,
            'evse_uid' => $this->evseUid,
            'connector_id' => $this->connectorId,
        ];

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
}
