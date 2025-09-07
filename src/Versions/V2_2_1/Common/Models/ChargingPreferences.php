<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;


use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class ChargingPreferences implements JsonSerializable
{
    private ProfileType $profileType;

    private ?DateTime $departureTime;

    private ?float $energyNeeded;

    private ?bool $dischargeAllowed;

    public function __construct(
        ProfileType $profileType,
        ?DateTime $departureTime,
        ?float $energyNeeded,
        ?bool $dischargeAllowed
    )
    {
        $this->profileType = $profileType;
        $this->departureTime = $departureTime;
        $this->energyNeeded = $energyNeeded;
        $this->dischargeAllowed = $dischargeAllowed;
    }

    public function getProfileType(): ProfileType
    {
        return $this->profileType;
    }

    public function getDepartureTime(): ?DateTime
    {
        return $this->departureTime;
    }

    public function getEnergyNeeded(): ?float
    {
        return $this->energyNeeded;
    }

    public function getDischargeAllowed(): ?bool
    {
        return $this->dischargeAllowed;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'profile_type' => $this->profileType,
        ];

        if ($this->departureTime) {
            $return['departure_time'] = DateTimeFormatter::format($this->departureTime);
        };

        if ($this->energyNeeded !== null) {
            $return['energy_needed'] = $this->energyNeeded;
        }

        if ($this->dischargeAllowed !== null) {
            $return['discharge_allowed'] = $this->dischargeAllowed;
        }

        return $return;
    }
}
