<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self ACCEPTED()
 * @method static self DEPARTURE_REQUIRED()
 * @method static self ENERGY_NEED_REQUIRED()
 * @method static self NOT_POSSIBLE()
 * @method static self PROFILE_TYPE_NOT_SUPPORTED()
 */
class ChargingPreferencesResponse extends Enum
{
    public const ACCEPTED = 'ACCEPTED';
    public const DEPARTURE_REQUIRED = 'DEPARTURE_REQUIRED';
    public const ENERGY_NEED_REQUIRED = 'ENERGY_NEED_REQUIRED';
    public const NOT_POSSIBLE = 'NOT_POSSIBLE';
    public const PROFILE_TYPE_NOT_SUPPORTED = 'PROFILE_TYPE_NOT_SUPPORTED';
}
