<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\StartSessionFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\StartSession;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class StartSessionFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/StartSession/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/StartSession/' . $filename),
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

        $price = StartSessionFactory::fromJson($json);

        self::assertStartSession($json, $price);
    }

    public static function assertStartSession(?stdClass $json, ?StartSession $command): void
    {
        if($json === null) {
            Assert::assertNull($command);
        } else {
            Assert::assertEquals($json->response_url, $command->getResponseUrl());
            TokenFactoryTest::assertToken($json->token, $command->getToken());
            Assert::assertEquals($json->location_id, $command->getLocationId());
            Assert::assertEquals($json->evse_uid ?? null, $command->getEvseUid());
        }
    }
}