<?php
declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_1_1\Common\Factories;

use Chargemap\OCPI\Versions\V2_1_1\Common\Factories\RegularHoursFactory;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\RegularHours;
use Chargemap\OCPI\Versions\V2_1_1\Common\Models\Weekday;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use stdClass;

class RegularHoursFactoryTest extends TestCase
{
    public function getFromJsonData(): iterable
    {
        foreach (scandir(__DIR__ . '/Payloads/RegularHours/') as $filename) {
            if ($filename !== '.' && $filename !== '..') {
                yield $filename => [
                    'payload' => file_get_contents(__DIR__ . '/Payloads/RegularHours/' . $filename),
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

        $regularHours = RegularHoursFactory::fromJson($json);

        self::assertRegularHours($json, $regularHours);
    }

    public static function assertRegularHours(?stdClass $json, ?RegularHours $regularHours): void
    {
        if($json === null) {
            Assert::assertNull($regularHours);
        } else {
            Assert::assertSame($json->period_begin, $regularHours->getPeriodBegin());
            Assert::assertSame($json->period_end, $regularHours->getPeriodEnd());
            Assert::assertEquals(new Weekday($json->weekday), $regularHours->getWeekday());
        }
    }
}