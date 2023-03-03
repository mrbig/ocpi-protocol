<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\TariffElement;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Common\Models\TariffElement
 */
class TariffElementTest
{
    public static function assertJsonSerialization(?TariffElement $tariffElement, ?stdClass $json): void
    {
        if ($tariffElement === null) {
            Assert::assertNull($json);
        } else {
            foreach ($tariffElement->getPriceComponents() as $index => $priceComponent) {
                PriceComponentTest::assertJsonSerialization($priceComponent, $json->price_components[$index]);
            }

            TariffRestrictionsTest::assertJsonSerialization($tariffElement->getRestrictions(), $json->restrictions ?? null);
        }
    }
}
