<?php

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CredentialsRole;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Common\Models\Credentials
 */
class CredentialsRoleTest
{
    public static function assertJsonSerialize(?CredentialsRole $credentialsRole, ?stdClass $json): void
    {
        if ($credentialsRole === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($credentialsRole->getRole()->getValue(), $json->role);
            Assert::assertSame($credentialsRole->getPartyId(), $json->party_id);
            Assert::assertSame($credentialsRole->getCountryCode(), $json->country_code);
            BusinessDetailsTest::assertJsonSerialization($credentialsRole->getBusinessDetails(), $json->business_details);
        }
    }
}
