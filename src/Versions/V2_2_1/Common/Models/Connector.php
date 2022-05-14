<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;


use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class Connector implements JsonSerializable
{
    private string $id;

    private ConnectorType $standard;

    private ConnectorFormat $format;

    private PowerType $powerType;

    private int $maxVoltage;

    private int $maxAmperage;

    private ?int $maxElectricPower;

    private ?string $tariffId;

    private ?string $termsAndConditions;

    private DateTime $lastUpdated;

    /**
     * Connector constructor.
     * @param string $id
     * @param ConnectorType $standard
     * @param ConnectorFormat $format
     * @param PowerType $powerType
     * @param int $maxVoltage
     * @param int $maxAmperage
     * @param int|null $max_electric_power
     * @param string|null $tariffId
     * @param string|null $termsAndConditions
     * @param DateTime $lastUpdated
     */
    public function __construct(string $id, ConnectorType $standard, ConnectorFormat $format, PowerType $powerType, int $maxVoltage, int $maxAmperage, ?int $maxElectricPower, ?string $tariffId, ?string $termsAndConditions, DateTime $lastUpdated)
    {
        $this->id = $id;
        $this->standard = $standard;
        $this->format = $format;
        $this->powerType = $powerType;
        $this->maxVoltage = $maxVoltage;
        $this->maxAmperage = $maxAmperage;
        $this->maxElectricPower = $maxElectricPower;
        $this->tariffId = $tariffId;
        $this->termsAndConditions = $termsAndConditions;
        $this->lastUpdated = $lastUpdated;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getStandard(): ConnectorType
    {
        return $this->standard;
    }

    public function getFormat(): ConnectorFormat
    {
        return $this->format;
    }

    public function getPowerType(): PowerType
    {
        return $this->powerType;
    }

    public function getMaxVoltage(): int
    {
        return $this->maxVoltage;
    }

    public function getMaxAmperage(): int
    {
        return $this->maxAmperage;
    }

    public function getMaxElectricPower(): ?int
    {
        return $this->maxElectricPower;
    }

    public function getTariffId(): ?string
    {
        return $this->tariffId;
    }

    public function getTermsAndConditions(): ?string
    {
        return $this->termsAndConditions;
    }

    public function getLastUpdated(): DateTime
    {
        return $this->lastUpdated;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'id' => $this->id,
            'standard' => $this->standard,
            'format' => $this->format,
            'power_type' => $this->powerType,
            'max_voltage' => $this->maxVoltage,
            'max_amperage' => $this->maxAmperage,
            'last_updated' => DateTimeFormatter::format($this->lastUpdated),
        ];

        if ($this->maxElectricPower !== null) {
            $return['max_electric_power'] = $this->maxElectricPower;
        }

        if ($this->tariffId !== null) {
            $return['tariff_id'] = $this->tariffId;
        }

        if ($this->termsAndConditions !== null) {
            $return['terms_and_conditions'] = $this->termsAndConditions;
        }

        return $return;
    }
}
