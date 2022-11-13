<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Password;

/**
 * Password generator class.
 *
 * @author Romain Cottard
 */
class PasswordGenerator
{
    private StringGenerator $generator;

    public function __construct(
        StringGenerator $generator
    ) {
        $this->generator = $generator;
    }

    /**
     * Generate password of given length.
     *
     * @param int $length
     * @param float $alpha
     * @param float $numeric
     * @param float $other
     * @param bool $removeAmbiguousChars
     * @return Password
     * @throws \Exception
     */
    public function generate(
        int $length = 16,
        float $alpha = 0.6,
        float $numeric = 0.2,
        float $other = 0.2,
        bool $removeAmbiguousChars = true
    ): Password {
        return new Password($this->generateString($length, $alpha, $numeric, $other, $removeAmbiguousChars));
    }

    /**
     * Generate string based on settings from constructor.
     *
     * @param int $length
     * @param float $alpha
     * @param float $numeric
     * @param float $other
     * @param bool $removeAmbiguousChars
     * @return string
     * @throws \Exception
     */
    public function generateString(
        int $length = 16,
        float $alpha = 0.6,
        float $numeric = 0.2,
        float $other = 0.2,
        bool $removeAmbiguousChars = true
    ): string {

        if ($length <= 0 || $alpha < 0 || $numeric < 0 || $other < 0 || ($alpha + $numeric + $other) < 0.5) {
            throw new \InvalidArgumentException('One of the argument is negative or sum of weights is close to null');
        }

        $chars = '';

        $weight = $length / ($alpha + $numeric + $other);

        if ($alpha > 0) {
            $chars .= $this->generator->generate(
                (int) ceil($alpha * $weight),
                StringGenerator::CHAR_ALPHA,
                $removeAmbiguousChars
            );
        }

        if ($numeric > 0) {
            $chars .= $this->generator->generate(
                (int) ceil($numeric * $weight),
                StringGenerator::CHAR_DIGITS,
                $removeAmbiguousChars
            );
        }

        if ($other > 0) {
            $chars .= $this->generator->generate(
                (int) ceil($other * $weight),
                StringGenerator::CHAR_SYMBOLS,
                $removeAmbiguousChars
            );
        }

        return substr($this->secureShuffle($chars), 0, $length);
    }

    /**
     * Secure shuffling using Fisher and Yates method (Durstenfeld implementation)
     *
     * @see    https://en.wikipedia.org/wiki/Fisher–Yates_shuffle
     * @param  string $chars
     * @return string
     */
    private function secureShuffle(string $chars): string
    {
        for ($i = strlen($chars) - 1; $i >= 1; --$i) {
            $j = random_int(0, $i);

            // Exchange i and j characters
            $temp      = $chars[$j];
            $chars[$j] = $chars[$i];
            $chars[$i] = $temp;
        }

        return $chars;
    }
}
