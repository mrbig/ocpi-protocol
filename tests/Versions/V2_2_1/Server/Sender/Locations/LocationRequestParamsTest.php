<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations;

use Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\LocationRequestGetParams;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\OCPI\Versions\V2_2_1\Server\Sender\Locations\LocationRequestGetParams
 */
class LocationRequestParamsTest extends TestCase
{
    public function invalidParametersProvider(): array
    {
        return [
            ['LOC10LOC10LOC10LOC10LOC10LOC10LOC10LOC10LOC10'],
            [''],
            ['LOC1', ''],
            ['LOC1', '', ''],
            ['LOC1', '3256', ''],
        ];
    }

    /**
     * @dataProvider invalidParametersProvider
     * @param string $locationId
     * @param string|null $evseId
     * @param string|null $connectorId
     */
    public function testShouldFailWithInvalidParameters(string $locationId, string $evseId = null, string $connectorId = null): void
    {
        $this->expectException(InvalidArgumentException::class);
        new LocationRequestGetParams($locationId, $evseId, $connectorId);
    }
}
