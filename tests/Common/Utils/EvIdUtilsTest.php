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
     * Data provider for testCalcChecksum
     * @return array 
     */
    public function provideValidateChecksum(): array
    {
        return [
            ['NN123ABCDEFGHIT', true],
            ['FRXYZ1234567891', false],
            ['ITA1B2C3E4F5G6-4', true],
            ['ESZU8WOX834H1D-X', false],
            ['PT73902837ABCZ', false, true],
            ['PT73902837ABCZ', true, false],
            ['DE83D-UIEN83QGZ-D', true],
            ['DE83D-uien83ZGQ-m', true],
            ['DE8-AA-001234567-0', true],
        ];
    }

    /**
     * Test the checksum calculation
     * @dataProvider provideTestCalcChecksum
     */
    public function testCalcChecksum(string $input, string $expected): void
    {
        $checksum = EvIdUtils::calcChecksum($input);
        $this->assertEquals($expected, $checksum);
    }

    /**
     * Test the addChecksum method
     * @dataProvider provideTestCalcChecksum
     */
    public function testAddChecksum(string $input, string $expected): void
    {
        $checksum = EvIdUtils::addChecksum($input);
        $this->assertEquals($input.'-'.$expected, $checksum);
    }

    /**
     * Test the checksum validation method
     * @dataProvider provideValidateChecksum
     */
    public function testValidateChecksum(string $input, bool $expected, bool $strict = false): void
    {
        $result = EvIdUtils::isChecksumValid($input, $strict);
        $this->assertEquals($expected, $result);
    }
}