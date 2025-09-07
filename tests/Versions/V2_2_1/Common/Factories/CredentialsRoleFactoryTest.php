<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\BusinessDetailsFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\CredentialsRoleFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\BusinessDetails;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CredentialsRole;
use JsonException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;

class CredentialsRoleFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/CredentialsRole/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/CredentialsRole/' . $filename),
                ];
            }
        }
    }

    /**
     * @param string $payload
     * @throws JsonException|InvalidPayloadException
     * @dataProvider getFromJsonData()
     */
    public function testFromJson(string $payload): void
    {
        $json = json_decode($payload, false, 512, JSON_THROW_ON_ERROR);

        OcpiTestCase::coerce('V2_2_1/Common/common.schema.json#/definitions/credentials_role', $json );

        $businessDetails = CredentialsRoleFactory::fromJson($json);

        self::assertCredentialRole($json, $businessDetails);
    }

    public static function assertCredentialRole(?stdClass $json, ?CredentialsRole $credentialsRole): void
    {
        if($json === null) {
            Assert::assertNull($credentialsRole);
        } else {
            Assert::assertSame($json->role, $credentialsRole->getRole()->getValue());
            Assert::assertSame($json->party_id, $credentialsRole->getPartyId());
            Assert::assertSame($json->country_code, $credentialsRole->getCountryCode());
            BusinessDetailsFactoryTest::assertBusinessDetails($json->business_details, $credentialsRole->getBusinessDetails());
        }
    }
}