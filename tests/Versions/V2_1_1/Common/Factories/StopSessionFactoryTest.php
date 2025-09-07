<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\StopSessionFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\StopSession;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class StopSessionFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/StopSession/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/StopSession/' . $filename),
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

        $price = StopSessionFactory::fromJson($json);

        self::assertStopSession($json, $price);
    }

    public static function assertStopSession(?stdClass $json, ?StopSession $command): void
    {
        if($json === null) {
            Assert::assertNull($command);
        } else {
            Assert::assertEquals($json->response_url, $command->getResponseUrl());
            Assert::assertEquals($json->session_id, $command->getSessionId());
        }
    }
}