<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\TokenFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\ProfileType;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Token;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\TokenType;
use DateTime;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class TokenFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/Token/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/Token/' . $filename),
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

        $price = TokenFactory::fromJson($json);

        self::assertToken($json, $price);
    }

    public static function assertToken(?stdClass $json, ?Token $token): void
    {
        if($json === null) {
            Assert::assertNull($token);
        } else {
            Assert::assertEquals($json->country_code, $token->getCountryCode());
            Assert::assertEquals($json->party_id, $token->getPartyId());
            Assert::assertEquals($json->uid, $token->getUid());
            Assert::assertEquals(new TokenType($json->type), $token->getType());
            Assert::assertEquals($json->contract_id, $token->getContractId());
            Assert::assertEquals($json->visual_number ?? null, $token->getVisualNumber());
            Assert::assertEquals($json->issuer, $token->getIssuer());
            Assert::assertEquals($json->group_id ?? null, $token->getGroupId());
            Assert::assertEquals($json->valid, $token->isValid());
            Assert::assertEquals($json->whitelist, $token->getWhiteList());
            Assert::assertEquals($json->language ?? null, $token->getLanguage());
            Assert::assertEquals(isset($json->default_profile_type) ? new ProfileType($json->default_profile_type) : null,
                $token->getDefaultProfileType());
            EnergyContractFactoryTest::assertEnergyContract($json->energy_contract ?? null, $token->getEnergyContract());
            Assert::assertEquals(new DateTime($json->last_updated), $token->getLastUpdated());
        }
    }
}