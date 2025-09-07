<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\PriceFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Price;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class PriceFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/Price/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/Price/' . $filename),
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

        $price = PriceFactory::fromJson($json);

        self::assertPrice($json, $price);
    }

    public static function assertPrice(?stdClass $json, ?Price $price): void
    {
        if($json === null) {
            Assert::assertNull($price);
        } else {
            Assert::assertEquals($json->excl_vat, $price->getExclVat());
            Assert::assertEquals($json->incl_vat ?? null, $price->getInclVat());
        }
    }
}