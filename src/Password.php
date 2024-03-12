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
 * Wrapper class for password_* php functions.
 * Can also generate a password
 *
 * @author Romain Cottard
 */
class Password
{
    protected string $passwordHashed = '';

    /**
     * Password constructor.
     *
     * @param string $password
     */
    public function __construct(private readonly string $password)
    {
        $this->hash();
    }

    /**
     * Get plain text password.
     *
     * @return string
     */
    public function getPlain(): string
    {
        return $this->password;
    }

    /**
     * Get hashed password.
     *
     * @return string
     */
    public function getHash(): string
    {
        return $this->passwordHashed;
    }

    /**
     * Hash the password.
     *
     * @return $this
     * @throws \UnexpectedValueException
     */
    public function hash(): self
    {
        $hash = \password_hash($this->password, PASSWORD_BCRYPT);

        if (empty($hash)) {
            throw new \UnexpectedValueException('Cannot hash password!'); // @codeCoverageIgnore
        }

        $this->passwordHashed = $hash;

        return $this;
    }

    /**
     * Verify the current password compared to the given hash.
     *
     * @param  string $passwordHashed
     * @return bool
     */
    public function verify(string $passwordHashed): bool
    {
        return \password_verify($this->password, $passwordHashed);
    }
}
