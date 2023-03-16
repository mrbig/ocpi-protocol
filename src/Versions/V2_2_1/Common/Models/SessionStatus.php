<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self ACTIVE()
 * @method static self COMPLETED()
 * @method static self INVALID()
 * @method static self PENDING()
 * @method static self RESERVATION()
 */
class SessionStatus extends Enum
{
    public const ACTIVE = 'ACTIVE';
    public const COMPLETED = 'COMPLETED';
    public const INVALID = 'INVALID';
    public const PENDING = 'PENDING';
    public const RESERVATION = 'RESERVATION';
}
