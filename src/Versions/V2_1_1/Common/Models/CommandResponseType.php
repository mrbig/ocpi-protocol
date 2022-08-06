<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_1_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self NOT_SUPPORTED()
 * @method static self REJECTED()
 * @method static self ACCEPTED()
 * @method static self TIMEOUT()
 * @method static self UNKNOWN_SESSION()
 */
class CommandResponseType extends Enum
{
    public const NOT_SUPPORTED = 'NOT_SUPPORTED';
    public const REJECTED = 'REJECTED';
    public const ACCEPTED = 'ACCEPTED';
    public const TIMEOUT = 'TIMEOUT';
    public const UNKNOWN_SESSION = 'UNKNOWN_SESSION';
}
