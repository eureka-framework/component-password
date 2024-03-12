<?php

/*
 * Copyright (c) Deezer
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Password;

/**
 * Password generator class.
 * Inspired from ircmaxell/randomLib
 *
 * @author Romain Cottard
 * @see ircmaxell/randomLib Generator class
 */
class StringGenerator
{
    /** @const A Bit for uppercase letters */
    public const CHAR_UPPER = 1;

    /** @const A Bit for lowercase letters */
    public const CHAR_LOWER = 2;

    /** @const Bits (sum) for alpha characters (combines UPPER + LOWER) */
    public const CHAR_ALPHA = 3; // CHAR_UPPER | CHAR_LOWER

    /** @const A Bit for digits */
    public const CHAR_DIGITS = 4;

    /** @const Bits (sum) for alphanumeric characters */
    public const CHAR_ALNUM = 7; // CHAR_ALPHA | CHAR_DIGITS

    /** @const Bits (sum) for uppercase hexadecimal symbols */
    public const CHAR_UPPER_HEX = 12; // 8 | CHAR_DIGITS

    /** @const Bits (sum)  for lowercase hexadecimal symbols */
    public const CHAR_LOWER_HEX = 20; // 16 | CHAR_DIGITS

    /** @const Bits (sum) for base64 symbols */
    public const CHAR_BASE64 = 39; // 32 | CHAR_ALNUM

    /** @const A Bit for additional symbols accessible via the keyboard */
    public const CHAR_SYMBOLS = 64;

    /** @const A Bit for brackets */
    public const CHAR_BRACKETS = 128;

    /** @const A Bit for punctuation marks */
    public const CHAR_PUNCT = 256;

    /** @const Bitwise for upper/lower-case and digits but without "B8G6I1l|0OQDS5Z2" */
    public const REMOVE_AMBIGUOUS_CHARS = 65536;

    /** @const string Ambiguous characters for "Easy To Read" sets*/
    private const AMBIGUOUS_CHARS = 'B8G6I1l|0OQDS5Z2()[]{}:;,.';

    /**
     * @var string[] The different characters, by Flag
     */
    public const STRING_LIST = [
        self::CHAR_UPPER     => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        self::CHAR_LOWER     => 'abcdefghijklmnopqrstuvwxyz',
        self::CHAR_DIGITS    => '0123456789',
        self::CHAR_UPPER_HEX => 'ABCDEF',
        self::CHAR_LOWER_HEX => 'abcdef',
        self::CHAR_BASE64    => '+/',
        self::CHAR_SYMBOLS   => '!"#$%&\'()* +,-./:;<=>?@[\]^_`{|}~',
        self::CHAR_BRACKETS  => '()[]{}<>',
        self::CHAR_PUNCT     => ',.;:',
    ];

    /**
     * @param int $length
     * @param int $flags
     * @param bool $removeAmbiguousChars
     * @return string
     * @throws \Exception
     */
    public function generate(int $length, int $flags = self::CHAR_BASE64, bool $removeAmbiguousChars = true): string
    {
        return $this->generateFromChars($length, $this->getCharsFromFlags($flags, $removeAmbiguousChars));
    }

    /**
     * @param int $length
     * @param string $chars
     * @return string
     * @throws \Exception
     */
    public function generateFromChars(int $length, string $chars): string
    {
        /** @var int<0,max> $max */
        $max    = \max(((int) \mb_strlen($chars)) - 1, 0); // Min 0, to avoid \Error when $max is -1
        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $char = \random_int(0, $max);
            $string .= $chars[$char];
        }

        return $string;
    }

    /**
     * Create string based on given flags.
     *
     * @param int $flags
     * @param bool $removeAmbiguousChars
     * @return string
     */
    private function getCharsFromFlags(int $flags, bool $removeAmbiguousChars = true): string
    {
        $string = '';
        foreach (self::STRING_LIST as $bitmask => $chars) {
            if (($bitmask & $flags) === $bitmask) {
                $string .= $chars;
            }
        }

        if ($removeAmbiguousChars) {
            $string = \str_replace(\str_split(self::AMBIGUOUS_CHARS), '', $string);
        }

        //~ Return string with unique chars
        return (string) \count_chars($string, 3);
    }
}
