<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\PriceComponent;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\TariffDimensionType;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Common\Models\PriceComponent
 */
class PriceComponentTest
{
    public static function assertJsonSerialization(?PriceComponent $priceComponent, ?stdClass $json): void
    {
        if ($priceComponent === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertEquals($priceComponent->getType(), TariffDimensionType::from($json->type));
            Assert::assertSame($priceComponent->getPrice(), $json->price);
            Assert::assertSame($priceComponent->getVat(), $json->vat);
            Assert::assertSame($priceComponent->getStepSize(), $json->step_size);
        }
    }
}
