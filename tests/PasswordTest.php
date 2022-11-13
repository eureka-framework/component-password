<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Password\Tests;

use Eureka\Component\Password\Password;
use PHPUnit\Framework\TestCase;

/**
 * Password generator test class
 *
 * @author Romain Cottard
 */
class PasswordTest extends TestCase
{
    public function testICanInstantiatePasswordClass(): void
    {
        $password = new Password('SomeSecretPassword1!');

        $this->assertInstanceOf(Password::class, $password);
    }

    public function testICanRetrievePlainPasswordFromPasswordInstance(): void
    {
        $password = new Password('SomeSecretPassword1!');

        $this->assertSame('SomeSecretPassword1!', $password->getPlain());
    }

    public function testICanRetrieveHashedPasswordFromPasswordInstance(): void
    {
        $password = new Password('SomeSecretPassword1!');

        $this->assertNotEmpty($password->getHash());
    }

    public function testICanVerifyAValidPassword(): void
    {
        $originalPasswordHash = $this->retrieveSomeHashedPasswordFromSomewhere();

        $correctPasswordToVerify = new Password('SomeSecretPassword1!');

        $this->assertTrue($correctPasswordToVerify->verify($originalPasswordHash));
    }

    public function testICannotVerifyAnInvalidPassword(): void
    {
        $originalPasswordHash = $this->retrieveSomeHashedPasswordFromSomewhere();

        $incorrectPasswordToVerify = new Password('SomeOtherSecretPassword2?');

        $this->assertFalse($incorrectPasswordToVerify->verify($originalPasswordHash));
    }

    private function retrieveSomeHashedPasswordFromSomewhere(): string
    {
        return (string) password_hash('SomeSecretPassword1!', PASSWORD_BCRYPT);
    }
}
