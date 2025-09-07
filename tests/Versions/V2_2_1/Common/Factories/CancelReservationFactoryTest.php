<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\CancelReservationFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CancelReservation;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class CancelReservationFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/CancelReservation/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/CancelReservation/' . $filename),
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

        $price = CancelReservationFactory::fromJson($json);

        self::assertCancelReservation($json, $price);
    }

    public static function assertCancelReservation(?stdClass $json, ?CancelReservation $command): void
    {
        if($json === null) {
            Assert::assertNull($command);
        } else {
            Assert::assertEquals($json->response_url, $command->getResponseUrl());
            Assert::assertEquals($json->reservation_id ?? null, $command->getReservationId());
        }
    }
}