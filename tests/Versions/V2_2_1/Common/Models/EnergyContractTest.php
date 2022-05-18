<?php

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use Chargemap\OCPI\Common\Utils\DateTimeFormatter;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\EnergyContract;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Common\Models\Token
 */
class EnergyContractTest
{
    public static function assertJsonSerialization(?EnergyContract $energyContract, ?stdClass $json): void
    {
        if ($energyContract === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($energyContract->getSupplierName(), $json->supplier_name);
            Assert::assertSame($energyContract->getContractId(), $json->contract_id ?? null);
        }
    }
}
