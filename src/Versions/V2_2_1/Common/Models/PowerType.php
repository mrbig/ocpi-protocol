<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self AC_1_PHASE()
 * @method static self AC_2_PHASE()
 * @method static self AC_2_PHASE_SPLIT()
 * @method static self AC_3_PHASE()
 * @method static self DC()
 */
class PowerType extends Enum
{
    public const AC_1_PHASE = 'AC_1_PHASE';
    public const AC_2_PHASE = 'AC_2_PHASE';
    public const AC_2_PHASE_SPLIT = 'AC_2_PHASE_SPLIT';
    public const AC_3_PHASE = 'AC_3_PHASE';
    public const DC = 'DC';
}
