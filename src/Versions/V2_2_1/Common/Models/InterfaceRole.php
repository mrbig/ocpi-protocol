<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self SENDER()
 * @method static self RECEIVER()
 */
class InterfaceRole extends Enum
{
    public const SENDER = 'SENDER';
    public const RECEIVER = 'RECEIVER';
}