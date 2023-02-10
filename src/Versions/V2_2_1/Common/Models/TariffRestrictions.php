<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use JsonSerializable;

class TariffRestrictions implements JsonSerializable
{
    private ?string $startTime;

    private ?string $endTime;

    private ?string $startDate;

    private ?string $endDate;

    private ?float $minKwh;

    private ?float $maxKwh;

    private ?float $minCurrent;

    private ?float $maxCurrent;

    private ?float $minPower;

    private ?float $maxPower;

    private ?int $minDuration;

    private ?int $maxDuration;

    private ?ReservationRestrictionType $reservation;

    /** @var DayOfWeek[] */
    private array $daysOfWeek = [];

    public function __construct(
        ?string $startTime,
        ?string $endTime,
        ?string $startDate,
        ?string $endDate,
        ?float $minKwh,
        ?float $maxKwh,
        ?float $minCurrent,
        ?float $maxCurrent,
        ?float $minPower,
        ?float $maxPower,
        ?int $minDuration,
        ?int $maxDuration,
        ?ReservationRestrictionType $reservation
    )
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->minKwh = $minKwh;
        $this->maxKwh = $maxKwh;
        $this->minCurrent = $minCurrent;
        $this->maxCurrent = $maxCurrent;
        $this->minPower = $minPower;
        $this->maxPower = $maxPower;
        $this->minDuration = $minDuration;
        $this->maxDuration = $maxDuration;
        $this->reservation = $reservation;
    }

    public function getStartTime(): ?string
    {
        return $this->startTime;
    }

    public function getEndTime(): ?string
    {
        return $this->endTime;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function getMinKwh(): ?float
    {
        return $this->minKwh;
    }

    public function getMaxKwh(): ?float
    {
        return $this->maxKwh;
    }

    public function getMinCurrent(): ?float
    {
        return $this->minCurrent;
    }

    public function getMaxCurrent(): ?float
    {
        return $this->maxCurrent;
    }

    public function getMinPower(): ?float
    {
        return $this->minPower;
    }

    public function getMaxPower(): ?float
    {
        return $this->maxPower;
    }

    public function getMinDuration(): ?int
    {
        return $this->minDuration;
    }

    public function getMaxDuration(): ?int
    {
        return $this->maxDuration;
    }

    /**
     * @return DayOfWeek[]
     */
    public function getDaysOfWeek(): array
    {
        return $this->daysOfWeek;
    }

    public function addDayOfWeek(DayOfWeek $dayOfWeek): self
    {
        $this->daysOfWeek[] = $dayOfWeek;

        return $this;
    }

    public function getReservation(): ?ReservationRestrictionType
    {
        return $this->reservation;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'day_of_week' => $this->daysOfWeek,
        ];

        if ($this->startTime !== null) {
            $return['start_time'] = $this->startTime;
        }
        if ($this->endTime !== null) {
            $return['end_time'] = $this->endTime;
        }
        if ($this->startDate !== null) {
            $return['start_date'] = $this->startDate;
        }
        if ($this->endDate !== null) {
            $return['end_date'] = $this->endDate;
        }
        if ($this->minKwh !== null) {
            $return['min_kwh'] = $this->minKwh;
        }
        if ($this->maxKwh !== null) {
            $return['max_kwh'] = $this->maxKwh;
        }
        if ($this->minCurrent !== null) {
            $return['min_current'] = $this->minCurrent;
        }
        if ($this->maxCurrent !== null) {
            $return['max_current'] = $this->maxCurrent;
        }
        if ($this->minPower !== null) {
            $return['min_power'] = $this->minPower;
        }
        if ($this->maxPower !== null) {
            $return['max_power'] = $this->maxPower;
        }
        if ($this->minDuration !== null) {
            $return['min_duration'] = $this->minDuration;
        }
        if ($this->maxDuration !== null) {
            $return['max_duration'] = $this->maxDuration;
        }
        if ($this->reservation !== null) {
            $return['reservation'] = $this->reservation;
        }

        return $return;
    }
}
