<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Password;

use RandomLib\Generator;

/**
 * Password generator class.
 *
 * @author Benoit Burnichon
 * @author Romain Cottard
 */
class PasswordGenerator
{
    /** @var \RandomLib\Generator $generator */
    private $generator;

    /** @var int $length Password length */
    private $length;

    /** @var float $alpha Ratio of alphabetic characters */
    private $alpha;

    /** @var float $numeric Ratio of numeric characters */
    private $numeric;

    /** @var float $numeric Ratio of others characters */
    private $other;

    /**
     * PasswordGenerator constructor.
     *
     * @param \RandomLib\Generator $generator
     * @param int   $length
     * @param float $alpha
     * @param float $numeric
     * @param float $other
     */
    public function __construct(Generator $generator, $length = 16, $alpha = 0.6, $numeric = 0.2, $other = 0.2)
    {
        $this->generator = $generator;

        $this->length  = (int) $length;
        $this->alpha   = (float) $alpha;
        $this->numeric = (float) $numeric;
        $this->other   = (float) $other;

        if ($this->length <= 0 || $this->alpha < 0 || $this->numeric < 0 || $this->other < 0 || ($this->alpha + $this->numeric + $this->other) < 0.5) {
            throw new \InvalidArgumentException('One of the argument is negative or sum of weights is close to null');
        }
    }

    /**
     * Generate string based on settings from constructor.
     *
     * @return string
     */
    public function generate()
    {
        $chars = '';

        $weight = $this->length / ($this->alpha + $this->numeric + $this->other);

        $generator = $this->generator;

        if ($this->alpha > 0) {
            $chars .= $generator->generateString((int) ceil($this->alpha * $weight), Generator::CHAR_ALPHA);
        }

        if ($this->numeric > 0) {
            $chars .= $generator->generateString((int) ceil($this->numeric * $weight), Generator::CHAR_DIGITS);
        }

        if ($this->other > 0) {
            $chars .= $generator->generateString((int) ceil($this->other * $weight), Generator::CHAR_SYMBOLS);
        }

        return substr($this->secureShuffle($chars), 0, $this->length);
    }

    /**
     * Secure shuffling using Fisher and Yates method (Durstenfeld implementation)
     *
     * @see    https://en.wikipedia.org/wiki/Fisher–Yates_shuffle
     * @param  string $chars
     * @return string
     */
    private function secureShuffle($chars)
    {
        for ($i = strlen($chars) - 1; $i >= 1; --$i) {
            $j = $this->generator->generateInt(0, $i);

            // Exchange i and j characters
            $temp      = $chars{$j};
            $chars{$j} = $chars{$i};
            $chars{$i} = $temp;
        }

        return $chars;
    }
}
