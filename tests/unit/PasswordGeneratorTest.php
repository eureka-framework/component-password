<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Password\Tests\Unit;

use Eureka\Component\Password;
use PHPUnit\Framework\TestCase;

/**
 * Password generator test class
 *
 * @author Romain Cottard
 */
class PasswordGeneratorTest extends TestCase
{
    public function testGeneratorThrowAnExceptionWhenConstructorParametersAreWrong(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $generator = new Password\PasswordGenerator(new Password\StringGenerator());
        $generator->generate(8, 0.1, 0.1, -1.0);
    }

    public function testItGeneratePasswordOfExpectedLength(): void
    {
        $generator = new Password\PasswordGenerator(new Password\StringGenerator());
        $password  = $generator->generate(8);

        self::assertEquals(8, mb_strlen($password->getPlain()));
    }

    public function testItGeneratePasswordWithOnlyAlphaCharacters(): void
    {
        $generator = new Password\PasswordGenerator(new Password\StringGenerator());
        $password  = $generator->generate(8, 1.0, 0.0, 0.0);

        $passwordPlain = $password->getPlain();
        for ($i = 0, $len = mb_strlen($passwordPlain); $i < $len; $i++) {
            $this->assertSame(1, preg_match('`[a-z]`i', $passwordPlain[$i]));
        }
    }

    public function testItGeneratePasswordWithOnlyNumericCharacters(): void
    {
        $generator = new Password\PasswordGenerator(new Password\StringGenerator());
        $password  = $generator->generate(8, 0.0, 1.0, 0.0);

        $passwordPlain = $password->getPlain();
        for ($i = 0, $len = mb_strlen($passwordPlain); $i < $len; $i++) {
            $this->assertSame(1, preg_match('`[0-9]`i', $passwordPlain[$i]));
        }
    }

    public function testItGeneratePasswordWithoutAlphaNumericCharacters(): void
    {
        $generator = new Password\PasswordGenerator(new Password\StringGenerator());
        $password  = $generator->generate(8, 0.0, 0.0, 1.0);

        $passwordPlain = $password->getPlain();
        for ($i = 0, $len = mb_strlen($passwordPlain); $i < $len; $i++) {
            $this->assertSame(1, preg_match('`[^a-z0-9]`i', $passwordPlain[$i]));
        }
    }
}
