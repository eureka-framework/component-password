<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Eureka\Component\Password;

class PasswordChecker
{
    /**
     * @param string $passwordString
     * @param string $hash
     * @return bool
     */
    public function verify(string $passwordString, string $hash): bool
    {
        $password = new Password($passwordString);

        return $password->verify($hash);
    }
}
