<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self RESERVE_NOW()
 * @method static self START_SESSION()
 * @method static self STOP_SESSION()
 * @method static self UNLOCK_CONNECTOR()
 */
class CommandType extends Enum
{
    public const RESERVE_NOW = 'RESERVE_NOW';
    public const START_SESSION = 'START_SESSION';
    public const STOP_SESSION = 'STOP_SESSION';
    public const UNLOCK_CONNECTOR = 'UNLOCK_CONNECTOR';
}
