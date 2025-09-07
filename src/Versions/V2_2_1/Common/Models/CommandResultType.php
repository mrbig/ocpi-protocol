<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self ACCEPTED()
 * @method static self CANCELED_RESERVATION()
 * @method static self EVSE_OCCUPIED()
 * @method static self EVSE_INOPERATIVE()
 * @method static self FAILED()
 * @method static self NOT_SUPPORTED()
 * @method static self REJECTED()
 * @method static self TIMEOUT()
 * @method static self UNKOWN_RESERVATION()
 */
class CommandResultType extends Enum
{
    public const ACCEPTED = 'ACCEPTED';
    public const CANCELED_RESERVATION = 'CANCELED_RESERVATION';
    public const EVSE_OCCUPIED = 'EVSE_OCCUPIED';
    public const EVSE_INOPERATIVE = 'EVSE_INOPERATIVE';
    public const FAILED = 'FAILED';
    public const NOT_SUPPORTED = 'NOT_SUPPORTED';
    public const REJECTED = 'REJECTED';
    public const TIMEOUT = 'TIMEOUT';
    public const UNKNOWN_RESERVATION = 'UNKNOWN_RESERVATION';
}
