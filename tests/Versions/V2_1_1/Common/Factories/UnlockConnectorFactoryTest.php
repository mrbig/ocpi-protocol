<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\UnlockConnectorFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\UnlockConnector;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class UnlockConnectorFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/UnlockConnector/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/UnlockConnector/' . $filename),
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

        $price = UnlockConnectorFactory::fromJson($json);

        self::assertUnlockConnetor($json, $price);
    }

    public static function assertUnlockConnetor(?stdClass $json, ?UnlockConnector $command): void
    {
        if($json === null) {
            Assert::assertNull($command);
        } else {
            Assert::assertEquals($json->response_url, $command->getResponseUrl());
            Assert::assertEquals($json->location_id, $command->getLocationId());
            Assert::assertEquals($json->evse_uid, $command->getEvseUid());
            Assert::assertEquals($json->connector_id, $command->getConnectorId());
        }
    }
}