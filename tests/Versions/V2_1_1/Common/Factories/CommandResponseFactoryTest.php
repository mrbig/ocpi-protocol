<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\CommandResponseFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\CommandResponse;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class CommandResponseFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/CommandResponse/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/CommandResponse/' . $filename),
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

        $price = CommandResponseFactory::fromJson($json);

        self::assertCommandResponse($json, $price);
    }

    public static function assertCommandResponse(?stdClass $json, ?CommandResponse $response): void
    {
        if($json === null) {
            Assert::assertNull($response);
        } else {
            Assert::assertEquals($json->result, $response->getResult());
        }
    }
}