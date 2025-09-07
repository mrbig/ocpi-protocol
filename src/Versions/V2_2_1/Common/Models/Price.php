<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use JsonSerializable;

class Price implements JsonSerializable
{
    private float $exclVat;

    private ?float $inclVat;

    public function __construct(
        float $exclVat,
        ?float $inclVat
    )
    {
        $this->exclVat = $exclVat;
        $this->inclVat = $inclVat;
    }

    public function getExclVat(): float {
        return $this->exclVat;
    }

    public function getInclVat(): ?float {
        return $this->inclVat;
    }

    public function jsonSerialize(): array
    {
        $return = [
            'excl_vat' => $this->exclVat,
            'incl_vat' => $this->inclVat,
        ];

        return $return;
    }
}
