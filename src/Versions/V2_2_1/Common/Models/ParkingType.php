<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use MyCLabs\Enum\Enum;

/**
 * @method static self ALONG_MOTORWAY()
 * @method static self PARKING_GARAGE()
 * @method static self PARKING_LOT()
 * @method static self ON_DRIVEWAY()
 * @method static self ON_STREET()
 * @method static self UNDERGROUND_GARAGE()
 */
class ParkingType extends Enum
{
    /**
     * Location on a parking facility/rest area along a motorway, freeway, interstate, highway etc.
     * @var string
     */
    public const ALONG_MOTORWAY = 'ALONG_MOTORWAY';

    /**
     * Multistorey car park.
     * @var string
     */
    public const PARKING_GARAGE = 'PARKING_GARAGE';

    /**
     * A cleared area that is intended for parking vehicles, i.e. at super markets, bars, etc.
     * @var string
     */
    public const PARKING_LOT = 'PARKING_LOT';

    /**
     * Location is on the driveway of a house/building.
     * @var string
     */
    public const ON_DRIVEWAY = 'ON_DRIVEWAY';

    /**
     * Parking in public space.
     * @var string
     */
    public const ON_STREET = 'ON_STREET';

    /**
     * Multistorey car park, mainly underground.
     * @var string
     */
    public const UNDERGROUND_GARAGE = 'UNDERGROUND_GARAGE';

}
