<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self AD_HOC_PAYMENT()
 * @method static self PROFILE_CHEAP()
 * @method static self PROFILE_FAST()
 * @method static self PROFILE_GREEN()
 * @method static self REGULAR()
 */
class TariffType extends Enum
{
    public const AD_HOC_PAYMENT = 'AD_HOC_PAYMENT';
    public const PROFILE_CHEAP = 'PROFILE_CHEAP';
    public const PROFILE_FAST  = 'PROFILE_FAST';
    public const PROFILE_GREEN = 'PROFILE_GREEN';
    public const REGULAR = 'REGULAR';
}