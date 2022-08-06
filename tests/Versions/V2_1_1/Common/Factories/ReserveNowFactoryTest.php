<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\ReserveNowFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\ReserveNow;
use DateTime;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class ReserveNowFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/ReserveNow/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/ReserveNow/' . $filename),
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

        $price = ReserveNowFactory::fromJson($json);

        self::assertReserveNow($json, $price);
    }

    public static function assertReserveNow(?stdClass $json, ?ReserveNow $command): void
    {
        if($json === null) {
            Assert::assertNull($command);
        } else {
            Assert::assertEquals($json->response_url, $command->getResponseUrl());
            TokenFactoryTest::assertToken($json->token, $command->getToken());
            Assert::assertEquals(new DateTime($json->expiry_date), $command->getExpiryDate());
            Assert::assertEquals($json->reservation_id, $command->getReservationId());
            Assert::assertEquals($json->location_id, $command->getLocationId());
            Assert::assertEquals($json->evse_uid ?? null, $command->getEvseUid());
        }
    }
}