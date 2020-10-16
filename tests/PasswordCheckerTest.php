<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Password\Tests;

use Eureka\Component\Password\PasswordChecker;
use PHPUnit\Framework\TestCase;

/**
 * Class PasswordCheckerTest
 *
 * @author Romain Cottard
 */
class PasswordCheckerTest extends TestCase
{
    /**
     * @return void
     */
    public function testICanVerifyAValidPassword()
    {
        $passwordChecker = new PasswordChecker();
        $passwordHash    = $this->retrieveSomeHashedPasswordFromSomewhere();
        $passwordPlain   = 'SomeSecretPassword1!';

        $this->assertTrue($passwordChecker->verify($passwordPlain, $passwordHash));
    }

    /**
     * @return void
     */
    public function testICannotVerifyAnInvalidPassword()
    {
        $passwordChecker = new PasswordChecker();
        $passwordHash    = $this->retrieveSomeHashedPasswordFromSomewhere();
        $passwordPlain   = 'SomeOtherSecretPassword2?';

        $this->assertFalse($passwordChecker->verify($passwordPlain, $passwordHash));
    }

    /**
     * @return string
     */
    private function retrieveSomeHashedPasswordFromSomewhere(): string
    {
        return password_hash('SomeSecretPassword1!', PASSWORD_BCRYPT);
    }
}
