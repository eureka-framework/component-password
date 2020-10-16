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
    /** @var string $password Plain text password */
    protected string $password = '';

    /** @var string|null|bool $passwordHashed Hashed password */
    protected $passwordHashed = '';

    /**
     * Password constructor.
     *
     * @param string $password
     */
    public function __construct(string $password)
    {
        $this->password = $password;

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
     * @throws \RuntimeException
     */
    public function hash(): self
    {
        $this->passwordHashed = password_hash($this->password, PASSWORD_BCRYPT);

        if (false === $this->passwordHashed) {
            throw new \RuntimeException('Cannot hash password!'); // @codeCoverageIgnore
        }

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
        return password_verify($this->password, $passwordHashed);
    }
}
