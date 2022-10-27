<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use JsonSerializable;

class PriceComponent implements JsonSerializable
{
    private TariffDimensionType $type;

    private float $price;

    private ?float $vat;

    private int $stepSize;

    public function __construct(TariffDimensionType $type, float $price, ?float $vat, int $stepSize)
    {
        $this->type = $type;
        $this->price = $price;
        $this->vat = $vat;
        $this->stepSize = $stepSize;
    }

    public function getType(): TariffDimensionType
    {
        return $this->type;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getVat(): ?float
    {
        return $this->vat;
    }

    public function getStepSize(): int
    {
        return $this->stepSize;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'type' => $this->type,
            'price' => $this->price,
            'step_size' => $this->stepSize
        ];
        if ($this->vat !== null) {
            $return['vat'] = $this->vat;
        }
        return $return;
    }
}