<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\AuthorizationInfoFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\AllowedType;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\AuthorizationInfo;
use JsonException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;
use Tests\Chargemap\OCPI\InvalidPayloadException;
use Tests\Chargemap\OCPI\OcpiTestCase;

class AuthorizationInfoFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/AuthorizationInfo/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/AuthorizationInfo/' . $filename),
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

        OcpiTestCase::coerce('V2_1_1/Common/common.schema.json#/definitions/authorization_info', $json );

        $businessDetails = AuthorizationInfoFactory::fromJson($json);

        self::assertAuthorizationInfo($json, $businessDetails);
    }

    public static function assertAuthorizationInfo(?stdClass $json, ?AuthorizationInfo $authorizationInfo): void
    {
        if($json === null) {
            Assert::assertNull($authorizationInfo);
        } else {
            Assert::assertEquals(AllowedType::from($json->allowed), $authorizationInfo->getAllowed());
            LocationReferencesFactoryTest::assertLocationReferences($json->location ?? null, $authorizationInfo->getLocation());
            DisplayTextFactoryTest::assertDisplayText($json->info ?? null, $authorizationInfo->getInfo());
        }
    }
}