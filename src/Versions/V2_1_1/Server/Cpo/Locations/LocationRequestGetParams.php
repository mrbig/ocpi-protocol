<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Server\Cpo\Locations;

use InvalidArgumentException;

class LocationRequestGetParams
{
    private string $locationId;

    private ?string $evseUid;

    private ?string $connectorId;

    public function __construct(string $locationId, string $evseUid = null, string $connectorId = null)
    {
        if (empty($locationId) || mb_strlen($locationId) > 36) {
            throw new InvalidArgumentException('Location ID should contain less than 36 characters.');
        }

        if ($evseUid !== null && (empty($evseUid) || mb_strlen($evseUid) > 36)) {
            throw new InvalidArgumentException('EVSE UID should contain less than 36 characters.');
        }

        if ($connectorId !== null && (empty($connectorId) || mb_strlen($connectorId) > 36)) {
            throw new InvalidArgumentException('Connector ID should contain less than 36 characters.');
        }

        $this->locationId = $locationId;
        $this->evseUid = $evseUid;
        $this->connectorId = $connectorId;
    }

    public function getLocationId(): string
    {
        return $this->locationId;
    }

    public function getEvseUid(): ?string
    {
        return $this->evseUid;
    }

    public function getConnectorId(): ?string
    {
        return $this->connectorId;
    }
}
