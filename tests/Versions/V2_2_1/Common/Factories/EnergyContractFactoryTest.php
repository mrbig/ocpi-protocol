<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\EnergyContractFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\EnergyContract;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class EnergyContractFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/EnergyContract/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/EnergyContract/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @throws \JsonException
     * @dataProvider getFromJsonData()
     */
    public function testFromJson(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        $price = EnergyContractFactory::fromJson($json);

        self::assertEnergyContract($json, $price);
    }

    public static function assertEnergyContract(?stdClass $json, ?EnergyContract $contract): void
    {
        if($json === null) {
            Assert::assertNull($contract);
        } else {
            Assert::assertEquals($json->supplier_name, $contract->getSupplierName());
            Assert::assertEquals($json->contract_id ?? null, $contract->getContractId());
        }
    }
}