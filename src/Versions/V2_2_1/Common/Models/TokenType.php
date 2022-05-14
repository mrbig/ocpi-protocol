<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self AD_HOC_USER()
 * @method static seld APP_USER()
 * @method static self RFID()
 * @method static self OTHER()
 */
class TokenType extends Enum
{
    public const AD_HOC_USER = 'AD_HOC_USER';
    public const APP_USER = 'APP_USER';
    public const RFID = 'RFID';
    public const OTHER = 'OTHER';
}
