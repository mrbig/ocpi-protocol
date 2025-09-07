<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self CHEAP()
 * @method static self FAST()
 * @method static self GREEN()
 * @method static self REGULAR()
 */
class ProfileType extends Enum
{
    public const CHEAP = 'CHEAP';
    public const FAST = 'FAST';
    public const GREEN = 'GREEN';
    public const REGULAR = 'REGULAR';
}
