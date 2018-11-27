<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
    protected $password = '';

    /** @var string $passwordHashed Hashed password */
    protected $passwordHashed = '';

    /**
     * Password constructor.
     *
     * @param string $password
     */
    public function __construct(string $password = '')
    {
        $this->password = $password;
    }

    /**
     * Generate password of given length.
     *
     * @param  int $length
     * @param  float $alpha   % alphabetic chars.
     * @param  float $numeric % of numeric chars
     * @param  float $other   % of other chars
     * @return $this
     */
    public function generate(int $length = 16, float $alpha = 0.6, float $numeric = 0.2, float $other = 0.2): self
    {
        $generator = new PasswordGenerator(
            new StringGenerator(),
            $length,
            $alpha,
            $numeric,
            $other
        );

        $this->password = $generator->generate();

        return $this;
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
     * Set plain text password.
     *
     * @param  string $password
     * @return $this
     */
    public function setPlain($password): self
    {
        $this->password = $password;

        return $this;
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
            throw new \RuntimeException('Cannot hash password!');
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
