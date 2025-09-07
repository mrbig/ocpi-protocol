<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

class FloorLevelFactory
{
    public static function fromString(?string $floorLevel): ?string
    {
        return $floorLevel;
    }
}