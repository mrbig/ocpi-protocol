<?php

declare(strict_types=1);

namespace Tests\Chargemap\OCPI\Common\Utils;

use Chargemap\OCPI\Common\Utils\EvIdUtils;
use PHPUnit\Framework\IncompleteTestError;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Chargemap\OCPI\Common\Utils\EvIdUtils
 */
class EvIdUtilsTest extends TestCase
{

    /**
     * Data provider for testCalcChecksum
     * @return array 
     */
    public function provideTestCalcChecksum(): array
    {
        return [
            ['NN123ABCDEFGHI', 'T'],
            ['FRXYZ123456789', '2'],
            ['ITA1B2C3E4F5G6', '4'],
            ['ESZU8WOX834H1D', 'R'],
            ['PT73902837ABCZ', 'Z'],
            ['DE83DUIEN83QGZ', 'D'],
            ['DE83DUIEN83ZGQ', 'M'],
            ['DE8-AA-001234567', '0'],
        ];
    }

    /**
     * 
     * @return void 
     * @dataProvider provideTestCalcChecksum
     */
    public function testCalcChecksum(string $input, string $expected): void
    {
        $checksum = EvIdUtils::calcChecksum($input);
        $this->assertEquals($expected, $checksum);
    }

    /**
     * 
     * @return void 
     * @dataProvider provideTestCalcChecksum
     */
    public function testAddChecksum(string $input, string $expected): void
    {
        $checksum = EvIdUtils::addChecksum($input);
        $this->assertEquals($input.'-'.$expected, $checksum);
    }
}