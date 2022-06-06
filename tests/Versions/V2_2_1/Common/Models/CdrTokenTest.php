<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\CdrTokenFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CdrToken;
use DateTime;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Common\Models\CdrToken
 */
class CdrTokenTest extends TestCase
{

     /**
     * @return mixed[][]
     */
    public function getJsonSerializeData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/CdrTokens') as $file) {
            if ($file !== '.' && $file !== '..') {
                yield $file => [
                    'payload' => json_decode(file_get_contents(__DIR__ . '/Payloads/CdrTokens/' . $file)),
                ];
            }
        }
    }

    /**
     * @param stdClass $payload
     * @dataProvider getJsonSerializeData()
     */
    public function testJsonSerialize(stdClass $payload): void
    {
        $cdrToken = CdrTokenFactory::fromJson($payload);

        self::assertJsonSerialization($cdrToken, $payload);
    }

    public static function assertJsonSerialization(?CdrToken $cdrToken, ?stdClass $json): void
    {
        if ($cdrToken === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($cdrToken->getCountryCode(), $json->country_code);
            Assert::assertSame($cdrToken->getPartyId(), $json->party_id);
            Assert::assertSame($cdrToken->getUid(), $json->uid);
            Assert::assertEquals($cdrToken->getType(), $json->type);
            Assert::assertSame($cdrToken->getContractId(), $json->contract_id);
        }
    }
}