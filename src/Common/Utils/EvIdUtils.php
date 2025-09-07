<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Utils;

/**
 * Methods to generate and validate Ev-ID checksums
 * @package Chargemap\OCPI\Common\Utils
 */
class EvIdUtils
{

    private static array $P1 = [
        [0,	1,	1,	1],
        [1,	1,	1,	0],
        [1,	0,	0,	1],
        [0,	1,	1,	1],
        [1,	1,	1,	0],
        [1,	0,	0,	1],
        [0,	1,	1,	1],
        [1,	1,	1,	0],
        [1,	0,	0,	1],
        [0,	1,	1,	1],
        [1,	1,	1,	0],
        [1,	0,	0,	1],
        [0,	1,	1,	1],
        [1,	1,	1,	0],
        [1,	0,	0,	1]
    ];

    private static array $P2 = [
        [0,	1,	1,	2],
        [1,	2,	2,	2],
        [2,	2,	2,	0],
        [2,	0,	0,	2],
        [0,	2,	2,	1],
        [2,	1,	1,	1],
        [1,	1,	1,	0],
        [1,	0,	0,	1],
        [0,	1,	1,	2],
        [1,	2,	2,	2],
        [2,	2,	2,	0],
        [2,	0,	0,	2],
        [0,	2,	2,	1],
        [2,	1,	1,	1],
        [1,	1,	1,	0]
    ];

    private static $list_alpha = [
        '0' => [0, 0,	0,	0,	0],
        '1' => [0, 0,	0,	1,	16],
        '2' => [0, 0,	0,	2,	32],
        '3' => [0, 0,	1,	0,	4],
        '4' => [0, 0,	1,	1,	20],
        '5' => [0, 0,	1,	2,	36],
        '6' => [0, 0,	2,	0,	8],
        '7' => [0, 0,	2,	1,	24],
        '8' => [0, 0,	2,	2,	40],
        '9' => [0, 1,	0,	0,	2],
        'A' => [0, 1,	0,	1,	18],
        'B' => [0, 1,	0,	2,	34],
        'C' => [0, 1,	1,	0,	6],
        'D' => [0, 1,	1,	1,	22],
        'E' => [0, 1,	1,	2,	38],
        'F' => [0, 1,	2,	0,	10],
        'G' => [0, 1,	2,	1,	26],
        'H' => [0, 1,	2,	2,	42],
        'I' => [1, 0,	0,	0,	1],
        'J' => [1, 0,	0,	1,	17],
        'K' => [1, 0,	0,	2,	33],
        'L' => [1, 0,	1,	0,	5],
        'M' => [1, 0,	1,	1,	21],
        'N' => [1, 0,	1,	2,	37],
        'O' => [1, 0,	2,	0,	9],
        'P' => [1, 0,	2,	1,	25],
        'Q' => [1, 0,	2,	2,	41],
        'R' => [1, 1,	0,	0,	3],
        'S' => [1, 1,	0,	1,	19],
        'T' => [1, 1,	0,	2,	35],
        'U' => [1, 1,	1,	0,	7],
        'V' => [1, 1,	1,	1,	23],
        'W' => [1, 1,	1,	2,	39],
        'X' => [1, 1,	2,	0,	11],
        'Y' => [1, 1,	2,	1,	27],
        'Z' => [1, 1,	2,	2,	43]
    ];


    /**
     * Generate the Ev-ID checksum for the given input
     * @param string $input the input to generate the checksum character for
     * @return ?string the checksum characters or null if the input is invalid
     */
    public static function calcChecksum(string $input): ?string
    {
        $input = self::normalizeInput($input);
        $matrix = self::DigitstoMatrix($input);
        $revDigit = self::calculateRevDigit($matrix);
        $checksum = self::array_search_multi($revDigit);
        return $checksum;
    }

    /**
     * Calculate the EV-ID checksum and add it to the input as [input]-[checksum]
     * @param string $input the input to process
     * @return string the input with the checksum added, or the original string, if
     *                the input is invalid
     */
    public static function addChecksum(string $input): string
    {
        $checksum = self::calcChecksum($input);
        return is_null($checksum) ? $input : $input . '-' . $checksum;
    }

    /**
     * Check if the input has a valid checksum
     * @param mixed $input the input to validate. Must contain 15 characters
     * @param bool $strict if true, missing checksums will be considered invalid
     * @return bool true if the checksum is valid, false otherwise
     */
    public static function isChecksumValid($input, bool $strict = false): bool
    {
        $input = self::normalizeInput($input);
        if (!preg_match('/^([A-Za-z]{2})([A-Za-z0-9]{3})([A-Za-z0-9]{9})([A-Za-z0-9])?(?=$)/', $input, $matches)) {
            return false;
        }
        if (!isset($matches[4])) {
            return !$strict;
        }
        return self::calcChecksum($matches[1] . $matches[2] . $matches[3]) === $matches[4];
    }

    /**
     * Convert the input to uppercase, and remove any - characters
     * @param string $input 
     * @return string 
     */
    private static function normalizeInput(string $input): string
    {
        $input = strtoupper($input);
        return preg_replace('/[-\*]?/', '', $input);
    }

    /**
     * Assign each character of the ID to a 2x2 matrix (4 characters) according to the alpha list
     * @param string $input the input id to process
     * @return array the matrix of digits
     */
    private static function DigitstoMatrix(string $input): array
    {
        $counter = 0;
        $matrix = [];
        for ($pos = 0; $pos < 14; $pos++) {
            for ($i = 0; $i < 4; $i++) {
                $matrix[$counter] = self::$list_alpha[$input[$pos]][$i];
                $counter++;
            }
        }
        return $matrix;
    }

    /**
     * Calculate the reverse digit of the given matrix using the CheckEquation P1 and P2
     * @param array $matrix the matrix to process
     * @return int the calculated digit
     */
    private static function calculateRevDigit(array $matrix): int
    {
        $c1 = 0;
        $c2 = 0;
        $c3 = 0;
        $c4 = 0;

        for ($i = 0; $i < 14; $i++) {
            $c1 += $matrix[$i * 4] * self::$P1[$i][0] + $matrix[$i * 4 + 1] * self::$P1[$i][2];
            $c2 += $matrix[$i * 4] * self::$P1[$i][1] + $matrix[$i * 4 + 1] * self::$P1[$i][3];
            $c3 += $matrix[$i * 4 + 2] * self::$P2[$i][0] + $matrix[$i * 4 + 3] * self::$P2[$i][2];
            $c4 += $matrix[$i * 4 + 2] * self::$P2[$i][1] + $matrix[$i * 4 + 3] * self::$P2[$i][3];
        }

        $c1 = $c1 % 2;
        $c2 = $c2 % 2;
        $c3 = $c3 % 3;
        $c4 = $c4 % 3;

        $q1 = $c1;
        $q2 = $c2;

        if ($c4 == 0) {
            $r1 = 0;
        }
        if ($c4 == 1) {
            $r1 = 2;
        }
        if ($c4 == 2) {
            $r1 = 1;
        }
        if ($c3 + $r1 == 0) {
            $r2 = 0;
        }
        if ($c3 + $r1 == 1) {
            $r2 = 2;
        }
        if ($c3 + $r1 == 2) {
            $r2 = 1;
        }
        if ($c3 + $r1 == 3) {
            $r2 = 0;
        }
        if ($c3 + $r1 == 4) {
            $r2 = 2;
        }
        return $q1 + $q2 * 2 + $r1 * 4 + $r2 * 16;
    }

    /**
     * Search the list_alpha array for the given reverse digit
     * @param int $revDigit the reverse digit to search for
     * @return string the key of the found element
     */
    public static function array_search_multi(int $revDigit): ?string
    {
        $key = null;
        foreach (self::$list_alpha as $key => $value) {
            if ($revDigit == $value[4]) {
                break;
            }
        }
        return is_null($key) ? null : (string)$key;
    }
}