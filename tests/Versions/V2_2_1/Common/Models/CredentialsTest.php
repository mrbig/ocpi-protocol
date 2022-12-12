<?php

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Models;

use Chargemap\OCPI\Versions\V2_2_1\Common\Models\Credentials;
use PHPUnit\Framework\Assert;
use stdClass;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Common\Models\Credentials
 */
class CredentialsTest
{
    public static function assertJsonSerialize(?Credentials $credentials, ?stdClass $json): void
    {
        if ($credentials === null) {
            Assert::assertNull($json);
        } else {
            Assert::assertSame($credentials->getUrl(), $json->url);
            Assert::assertSame($credentials->getToken(), $json->token);
            foreach($credentials->getRoles() as $idx => $role) {
                CredentialsRoleTest::assertJsonSerialize($role, $json->roles[$idx]);
            }
        }
    }
}
