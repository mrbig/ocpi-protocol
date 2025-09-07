<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\DayOfWeek;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\TariffRestrictions;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Common\Models\TariffRestrictions
 */
class TariffRestrictionsTest
{
    public static function assertJsonSerialization(?TariffRestrictions $tariffRestrictions, ?stdClass $json): void
    {
        if ($tariffRestrictions === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($tariffRestrictions->getStartTime(), $json->start_time ?? null);
            Assert::assertSame($tariffRestrictions->getEndTime(), $json->end_time ?? null);
            Assert::assertSame($tariffRestrictions->getStartDate(), $json->start_date ?? null);
            Assert::assertSame($tariffRestrictions->getEndDate(), $json->end_date ?? null);
            Assert::assertSame($tariffRestrictions->getMinKwh(), $json->min_kwh ?? null);
            Assert::assertSame($tariffRestrictions->getMaxKwh(), $json->max_kwh ?? null);
            Assert::assertSame($tariffRestrictions->getMinCurrent(), $json->min_current ?? null);
            Assert::assertSame($tariffRestrictions->getMaxCurrent(), $json->max_current ?? null);
            Assert::assertSame($tariffRestrictions->getMinPower(), $json->min_power ?? null);
            Assert::assertSame($tariffRestrictions->getMaxPower(), $json->max_power ?? null);
            Assert::assertSame($tariffRestrictions->getMinDuration(), $json->min_duration ?? null);
            Assert::assertSame($tariffRestrictions->getMaxDuration(), $json->max_duration ?? null);

            if (empty($tariffRestrictions->getDaysOfWeek())) {
                Assert::assertEmpty($json->day_of_week ?? null);
            } else {
                foreach ($tariffRestrictions->getDaysOfWeek() as $index => $dayOfWeek) {
                    Assert::assertEquals($dayOfWeek, DayOfWeek::from($json->day_of_week[$index]));
                }
            }
            Assert::assertSame($tariffRestrictions->getReservation(), $json->reservation ?? null);
        }
    }
}
