<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Password\Script;

use Eureka\Component\Console;
use Eureka\Component\Password\Password;
use Eureka\Component\Password\PasswordGenerator;
use Eureka\Component\Password\StringGenerator;

/**
 * Console Abstraction class.
 * Must be parent class for every console script class.
 *
 * @author  Romain Cottard
 *
 * @codeCoverageIgnore
 */
class Generator extends Console\AbstractScript
{
    /**
     * Generator constructor.
     */
    public function __construct()
    {
        $this->setDescription('Password generator');
        $this->setExecutable();
    }

    /**
     * @return void
     */
    public function help(): void
    {
        (new Console\Help('...'))
            ->addArgument('g', 'generate', 'Generate password')
            ->addArgument('l', 'length', 'Password length', true)
            ->addArgument('a', 'ratio-alpha', 'Alphabetic latin characters ratio', true)
            ->addArgument('n', 'ratio-numeric', 'Numeric characters ratio', true)
            ->addArgument('o', 'ratio-other', 'Other characters ratio', true)
            ->display()
        ;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        $argument = Console\Argument\Argument::getInstance();

        $doGenerate = $argument->has('generate', 'g');

        if ($doGenerate) {
            $length  = (int) $argument->get('l', 'length', 16);
            $alpha   = (float) $argument->get('a', 'ratio-alpha', 0.6);
            $numeric = (float) $argument->get('n', 'ratio-numeric', 0.2);
            $other   = (float) $argument->get('o', 'ratio-other', 0.2);
            $password = (new PasswordGenerator(new StringGenerator()))->generate($length, $alpha, $numeric, $other);
        } else {
            Console\IO\Out::std('Type your password: ', '');
            $plain = trim((string) fgets(STDIN));
            if (empty($plain)) {
                throw new \RuntimeException('Empty password');
            }
            $password = new Password($plain);
        }

        $password->hash();

        Console\IO\Out::std('');
        Console\IO\Out::std('Plain: ' . $password->getPlain());
        Console\IO\Out::std('Hash:  ' . $password->getHash());
    }
}
