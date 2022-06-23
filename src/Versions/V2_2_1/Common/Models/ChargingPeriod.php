<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class ChargingPeriod implements JsonSerializable
{
    private DateTime $startDate;

    /** @var CdrDimension[] */
    private array $cdrDimensions = [];

    private ?string $tariffId;

    public function __construct(DateTime $startDate, ?string $tariffId)
    {
        $this->startDate = $startDate;
        $this->tariffId = $tariffId;
    }

    public function addDimension(CdrDimension $dimension): self
    {
        $previousIndex = $this->searchCdrDimension($dimension->getType());

        if ($previousIndex !== null) {
            $this->cdrDimensions[$previousIndex] = $dimension;
        } else {
            $this->cdrDimensions[] = $dimension;
        }
        return $this;
    }

    public function getStartDate(): DateTime
    {
        return $this->startDate;
    }

    /** @return CdrDimension[] */
    public function getCdrDimensions(): array
    {
        return $this->cdrDimensions;
    }

    public function getCdrDimension(CdrDimensionType $dimensionType): ?CdrDimension
    {
        $index = $this->searchCdrDimension($dimensionType);

        if ($index === null) {
            return null;
        }

        return $this->cdrDimensions[$index];
    }

    public function getTariffId(): ?string
    {
        return $this->tariffId;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'start_date_time' => DateTimeFormatter::format($this->startDate),
            'dimensions' => $this->cdrDimensions,
        ];
        if ($this->tariffId) {
            $return['tariff_id'] = $this->tariffId;
        }
        return $return;
    }

    private function searchCdrDimension(CdrDimensionType $dimensionType): ?int
    {
        foreach ($this->cdrDimensions as $index => $cdrDimension) {
            if ($cdrDimension->getType()->equals($dimensionType)) {
                return $index;
            }
        }

        return null;
    }
}
