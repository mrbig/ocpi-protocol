<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\CdrTokenFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CdrToken;
use DateTime;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class CdrTokenFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/CdrToken/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/CdrToken/' . $filename),
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

        $connector = CdrTokenFactory::fromJson($json);

        self::assertCdrToken($json, $connector);
    }

    public static function assertCdrToken(?stdClass $json, ?CdrToken $cdrToken): void
    {
        if($json === null) {
            Assert::assertNull($cdrToken);
        } else {
            Assert::assertSame($json->country_code, $cdrToken->getCountryCode());
            Assert::assertSame($json->party_id, $cdrToken->getPartyId());
            Assert::assertSame($json->uid, $cdrToken->getUid());
            Assert::assertEquals($json->type, $cdrToken->getType());
            Assert::assertSame($json->contract_id, $cdrToken->getContractId());
        }
    }
}