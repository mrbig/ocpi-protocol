<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use JsonSerializable;

class CdrLocation implements JsonSerializable
{
    private string $id;

    private ?string $name;

    private string $address;

    private string $city;

    private ?string $postalCode;

    private ?string $state;

    private string $country;

    private GeoLocation $coordinates;

    private string $evseUid;
    
    private string $evseId;

    private string $connectorId;

    private ConnectorType $connectorStandard;

    private ConnectorFormat $connectorFormat;

    private PowerType $connectorPowerType;

    public function __construct(
        string $id,
        ?string $name,
        string $address,
        string $city,
        ?string $postalCode,
        ?string $state,
        string $country,
        GeoLocation $coordinates,
        string $evseUid,
        string $evseId,
        string $connectorId,
        ConnectorType $connectorStandard,
        ConnectorFormat $connectorFormat,
        PowerType $connectorPowerType
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->state = $state;
        $this->country = $country;
        $this->coordinates = $coordinates;
        $this->evseUid = $evseUid;
        $this->evseId = $evseId;
        $this->connectorId = $connectorId;
        $this->connectorStandard = $connectorStandard;
        $this->connectorFormat = $connectorFormat;
        $this->connectorPowerType = $connectorPowerType;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCoordinates(): GeoLocation
    {
        return $this->coordinates;
    }

    public function getEvseUid(): string
    {
        return $this->evseUid;
    }

    public function getEvseId(): string
    {
        return $this->evseId;
    }

    public function getConnectorId(): string
    {
        return $this->connectorId;
    }

    public function getConectorStandard(): ConnectorType
    {
        return $this->connectorStandard;
    }

    public function getConnectorFormat(): ConnectorFormat
    {
        return $this->connectorFormat;
    }

    public function getConnectorPowerType(): PowerType
    {
        return $this->connectorPowerType;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'id' => $this->id,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'coordinates' => $this->coordinates,
            'evse_uid' => $this->evseUid,
            'evse_id' => $this->evseId,
            'connector_id' => $this->connectorId,
            'connector_standard' => $this->connectorStandard,
            'connector_format' => $this->connectorFormat,
            'connector_power_type' => $this->connectorPowerType,
        ];

        if ($this->name) {
            $return['name'] = $this->name;
        }

        if ($this->postalCode) {
            $return['postal_code'] = $this->postalCode;
        }

        if ($this->state) {
            $return['state'] = $this->state;
        }

        return $return;
    }
}
