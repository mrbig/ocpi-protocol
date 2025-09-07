<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_2_1\Common\Factories\CommandResultFactory;
use Chargemap\OCPI\Versions\V2_2_1\Common\Models\CommandResult;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class CommandResultFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/CommandResult/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/CommandResult/' . $filename),
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

        $price = CommandResultFactory::fromJson($json);

        self::assertCommandResult($json, $price);
    }

    public static function assertCommandResult(?stdClass $json, ?CommandResult $result): void
    {
        if($json === null) {
            Assert::assertNull($result);
        } else {
            Assert::assertEquals($json->result, $result->getResult());
            foreach ($result->getMessages() as $index => $message) {
                DisplayTextFactoryTest::assertDisplayText($json->message[$index], $message);
            }
        }
    }
}