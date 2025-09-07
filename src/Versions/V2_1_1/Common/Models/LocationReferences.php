<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use JsonSerializable;

class LocationReferences implements JsonSerializable
{
    private string $locationId;

    /** @var string[] */
    private array $evseUids = [];

    /** @var string[] */
    private array $connectorIds = [];

    public function __construct(string $locationId)
    {
        $this->locationId = $locationId;
    }

    public function addEvseUid(string $evseUid): self
    {
        $this->evseUids[] = $evseUid;
        return $this;
    }

    public function addConnectorId($connectorId): self
    {
        $this->connectorIds[] = $connectorId;
        return $this;
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }

    public function getEvseUids(): array
    {
        return $this->evseUids;
    }

    public function getConnectorIds(): array
    {
        return $this->connectorIds;
    }

    public function jsonSerialize(): array
    {
        return [
            'location_id' => $this->locationId,
            'evse_uids' => $this->evseUids,
            'connector_ids' => $this->connectorIds
        ];
    }
}
