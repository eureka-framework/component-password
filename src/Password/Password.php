<?php

/**
 * Copyright (c) 2010-2016 Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Password;

/**
 * Wrapper class for password_* php functions from
 *
 * @author Romain Cottard
 */
class Password
{
    /**
     * @var string Plain text password
     */
    protected $password = '';

    /**
     * @var string Hashed password
     */
    protected $passwordHashed = '';

    /**
     * Password constructor.
     *
     * @param string $password
     */
    public function __construct($password = '')
    {
        $this->password = $password;
    }

    /**
     * Generate password of given length.
     *
     * @param  int   $length
     * @param  float $alpha % alphabetic chars.
     * @param  float $numeric % of numeric chars
     * @param  float $other % of other chars
     * @return self
     */
    public function generate($length = 16, $alpha = 0.6, $numeric = 0.2, $other = 0.2)
    {
        $chars = array();

        //~ Alphabetic characters
        for ($index = 0, $max = ceil($alpha * $length); $index < $max; $index++) {
            if ((bool) rand(0, 1)) {
                $char = rand(65, 90); // Upper
            } else {
                $char = rand(97, 122); // Lower
            }

            $chars[] = chr($char);
        }

        //~ Alphabetic characters
        for ($index = 0, $max = ceil($numeric * $length); $index < $max; $index++) {
            $char    = rand(48, 57); // Number
            $chars[] = chr($char);
        }

        //~ Other printable chars
        for ($index = 0, $max = ceil($other * $length); $index < $max; $index++) {

            switch ((int) rand(1, 4)) {
                case 1:
                    $char = rand(33, 47);
                    break;
                case 2:
                    $char = rand(58, 64);
                    break;
                case 3:
                    $char = rand(91, 96);
                    break;
                case 4:
                default:
                    $char = rand(123, 126);
                    break;
            }

            $chars[] = chr($char);
        }

        shuffle($chars);

        $this->password = implode('', array_slice($chars, 0, 16));

        return $this;
    }

    /**
     * Get plain text password.
     *
     * @return string
     */
    public function getPlain()
    {
        return $this->password;
    }

    /**
     * Get hashed password.
     *
     * @return string
     */
    public function getHash()
    {
        return $this->passwordHashed;
    }

    /**
     * Hash the password.
     *
     * @return self
     */
    public function hash()
    {
        $this->passwordHashed = password_hash($this->password, PASSWORD_DEFAULT);

        return $this;
    }

    /**
     * Verify the current password compared to the given hash.
     *
     * @param  string $passwordHashed
     * @return bool
     */
    public function verify($passwordHashed)
    {
        return password_verify($this->password, $passwordHashed);
    }
}