<?php

namespace App\Helper;

use Exception;

class Color
{
    const BLACK = "#000000";
    const WHITE = "#FFFFFF";
    const GREEN = "#00FF00";
    const ORANGE = "#FF8800";

    const COLOR_PATTERN = "/^#(?<red>[0-9A-F]{2})(?<green>[0-9A-F]{2})(?<blue>[0-9A-F]{2})$/";
    const COLOR_ERROR = "%s color not recognised, you must format the color in hexadecimal (#XXXXXX)";

    /**
     * Convert from hexadecimal
     * 
     * @param string $color
     *
     * @return array
     * @throws Exception
     */
    static function fromHex(string $color): array
    {
        $color = mb_convert_case($color, MB_CASE_UPPER);
        preg_match_all(self::COLOR_PATTERN, $color, $match, PREG_SET_ORDER);
        if (!$match) {
            throw new Exception(sprintf(self::COLOR_ERROR, $color));
        }

        return [
            hexdec($match[0]['red']),
            hexdec($match[0]['green']),
            hexdec($match[0]['blue'])
        ];
    }
}