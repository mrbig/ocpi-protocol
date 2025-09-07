<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Common\Utils\PartialModel;
use DateTime;
use JsonSerializable;

class PartialTariff extends PartialModel implements JsonSerializable
{

    private ?string $id = null;
    private ?string $currency = null;

    /** @var DisplayText[] */
    private ?array $tariffAltText = null;

    private ?string $tariffAltUrl;

    /** @var TariffElement[] */
    private ?array $elements = null;

    private ?EnergyMix $energyMix;

    private ?DateTime $lastUpdated;

    protected function _withId(?string $id): self
    {
        $this->id = $id;
        return $this;
    }

    protected function _withCurrency(?string $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    protected function _withTariffAltText(): self
    {
        $this->tariffAltText = [];
        return $this;
    }

    public function withTariffAltTextItem(DisplayText $text): self
    {
        $this->tariffAltText[] = $text;

        return $this;
    }

    protected function _withTariffAltUrl(?string $tariffAltUrl): self
    {
        $this->tariffAltUrl = $tariffAltUrl;
        return $this;
    }

    protected function _withElements(): self
    {
        $this->elements = [];
        return $this;
    }

    public function withElement(TariffElement $element): self
    {
        $this->elements[] = $element;

        return $this;
    }

    protected function _withEnergyMix(?EnergyMix $energyMix): self
    {
        $this->energyMix = $energyMix;
        return $this;
    }

    protected function _withLastUpdated(?DateTime $lastUpdated): self
    {
        $this->lastUpdated = $lastUpdated;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function getTariffAltText(): ?array
    {
        return $this->tariffAltText;
    }

    public function getTariffAltUrl(): ?string
    {
        return $this->tariffAltUrl;
    }

    public function getElements(): ?array
    {
        return $this->elements;
    }

    public function getEnergyMix(): ?EnergyMix
    {
        return $this->energyMix;
    }

    public function getLastUpdated(): ?DateTime
    {
        return $this->lastUpdated;
    }

    public function jsonSerialize(): array
    {
        $return = [];

        if ($this->hasId()) {
            $return['id'] = $this->id;
        }

        if ($this->hasCurrency()) {
            $return['currency'] = $this->currency;
        }

        if ($this->hasTariffAltText()) {
            $return['tariff_alt_text'] = $this->tariffAltText;
        }

        if ($this->hasTariffAltUrl()) {
            $return['tariff_alt_url'] = $this->tariffAltUrl;
        }

        if ($this->hasElements()) {
            $return['elements'] = $this->elements;
        }

        if ($this->hasEnergyMix()) {
            $return['energy_mix'] = $this->energyMix;
        }

        if ($this->hasLastUpdated()) {
            $return['last_updated'] = DateTimeFormatter::format($this->lastUpdated);
        }

        return $return;

    }

}