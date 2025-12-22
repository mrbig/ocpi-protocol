<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\SignedDataFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\SignedData;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\SignedValue;
use DateTime;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class SignedDataFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/SignedData/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/SignedData/' . $filename),
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

        $signedData = SignedDataFactory::fromJson($json);

        self::assertSignedData($json, $signedData);
    }

    public static function assertSignedData(?stdClass $json, ?SignedData $signedData): void
    {
        if($json === null) {
            Assert::assertNull($signedData);
        } else {
            Assert::assertEquals($json->encoding_method, $signedData->getEncodingMethod());
            Assert::assertEquals($json->encoding_method_version ?? null, $signedData->getEncodingMethodVersion());
            Assert::assertEquals($json->public_key ?? null, $signedData->getPublicKey());
            foreach ($signedData->getSignedValues() as $index => $signedValue) {
                self::assertSignedValue($json->signed_values[$index], $signedValue);
            }
            Assert::assertSame(count($json->signed_values ?? []), count($signedData->getSignedValues()));
            Assert::assertEquals($json->url ?? null, $signedData->getUrl());
        }
    }

    public static function assertSignedValue(?stdClass $json, ?SignedValue $signedValue): void{
        if($json === null) {
            Assert::assertNull($signedValue);
        } else {
            Assert::assertEquals($json->nature, $signedValue->getNature());
            Assert::assertEquals($json->plain_data, $signedValue->getPlainData());
            Assert::assertEquals($json->signed_data, $signedValue->getSignedData());
        }
    }
}