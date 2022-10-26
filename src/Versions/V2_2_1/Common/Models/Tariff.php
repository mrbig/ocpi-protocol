<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use DateTime;
use JsonSerializable;

class Tariff implements JsonSerializable
{
    private string $countryCode;

    private string $partyId;

    private string $id;

    private string $currency;

    private ?TariffType $type;

    /** @var DisplayText[] */
    private array $tariffAltText = [];

    private ?string $tariffAltUrl;

    private ?Price $minPrice;

    private ?Price $maxPrice;

    /** @var TariffElement[] */
    private array $elements = [];

    private ?DateTime $startDateTime;

    private ?DateTime $endDateTime;

    private ?EnergyMix $energyMix;

    private DateTime $lastUpdated;

    public function __construct(
        string $countryCode,
        string $partyId,
        string $id,
        string $currency,
        ?TariffType $type,
        ?string $tariffAltUrl,
        ?Price $minPrice,
        ?Price $maxPrice,
        ?DateTime $startDateTime,
        ?DateTime $endDateTime,
        ?EnergyMix $energyMix,
        DateTime $lastUpdated)
    {
        $this->countryCode = $countryCode;
        $this->partyId = $partyId;
        $this->id = $id;
        $this->currency = $currency;
        $this->type = $type;
        $this->tariffAltUrl = $tariffAltUrl;
        $this->minPrice = $minPrice;
        $this->maxPrice = $maxPrice;
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
        $this->energyMix = $energyMix;
        $this->lastUpdated = $lastUpdated;
    }

    public function addTariffAltText(DisplayText $text): self
    {
        $this->tariffAltText[] = $text;

        return $this;
    }

    public function addTariffElement(TariffElement $element): self
    {
        $this->elements[] = $element;

        return $this;
    }

    /**
     * Get the value of countryCode
     */ 
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * Get the value of partyId
     */ 
    public function getPartyId()
    {
        return $this->partyId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getType(): ?TariffType
    {
        return $this->type;
    }

    /**
     * @return DisplayText[]
     */
    public function getTariffAltText(): array
    {
        return $this->tariffAltText;
    }

    public function getTariffAltUrl(): ?string
    {
        return $this->tariffAltUrl;
    }

    /**
     * Get the value of minPrice
     */ 
    public function getMinPrice()
    {
        return $this->minPrice;
    }

    /**
     * Get the value of maxPrice
     */ 
    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    /**
     * @return TariffElement[]
     */
    public function getElements(): array
    {
        return $this->elements;
    }
     
    /**
     * Get the value of startDateTime
     */ 
    public function getStartDateTime()
    {
        return $this->startDateTime;
    }

    /**
     * Get the value of endDateTime
     */ 
    public function getEndDateTime()
    {
        return $this->endDateTime;
    }

    public function getEnergyMix(): ?EnergyMix
    {
        return $this->energyMix;
    }

    public function getLastUpdated(): DateTime
    {
        return $this->lastUpdated;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'country_code' => $this->countryCode,
            'party_id' => $this->partyId,
            'id' => $this->id,
            'currency' => $this->currency,
            'elements' => $this->elements,
            'last_updated' => DateTimeFormatter::format($this->lastUpdated),
        ];

        if ($this->type !== null) {
            $return['type'] = $this->type;
        }

        if (count($this->tariffAltText) > 0) {
            $return['tariff_alt_text'] = $this->tariffAltText;
        }

        if ($this->tariffAltUrl !== null) {
            $return['tariff_alt_url'] = $this->tariffAltUrl;
        }

        if ($this->minPrice !== null) {
            $return['min_price'] = $this->minPrice;
        }

        if ($this->maxPrice !== null) {
            $return['max_price'] = $this->maxPrice;
        }

        if ($this->startDateTime !== null) {
            $return['start_date_time'] = DateTimeFormatter::format($this->startDateTime);
        }

        if ($this->endDateTime !== null) {
            $return['end_date_time'] = DateTimeFormatter::format($this->endDateTime);
        }

        if ($this->energyMix !== null) {
            $return['energy_mix'] = $this->energyMix;
        }

        return $return;
    }
}
