<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use JsonSerializable;

class EnvironmentalImpact implements JsonSerializable
{
    private EnvironmentalImpactCategory $category;

    private float $amount;

    public function __construct(EnvironmentalImpactCategory $category, float $amount)
    {
        $this->category = $category;
        $this->amount = $amount;
    }

    public function getCategory(): EnvironmentalImpactCategory
    {
        return $this->category;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function jsonSerialize(): array
    {
        return [
            'category' => $this->category,
            'amount' => $this->amount,
        ];
    }
}

