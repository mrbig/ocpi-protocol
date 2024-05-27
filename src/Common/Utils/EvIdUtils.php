<?php

declare(strict_types=1);

namespace Chargemap\OCPI\Common\Utils;

/**
 * Methods to generate and validate Ev-ID checksums
 * @package Chargemap\OCPI\Common\Utils
 */
class EvIdUtils
{
    /**
     * Generate the Ev-ID checksum for the given input
     * @param string $input the input to generate the checksum character for
     * @return string the checksum characters
     */
    public static function calcChecksum(string $input): string
    {
        return '';
    }
}