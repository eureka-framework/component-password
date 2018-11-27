<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Password\Script;

use Eureka\Component\Password\Password;
use Eureka\Eurekon;

/**
 * Console Abstraction class.
 * Must be parent class for every console script class.
 *
 * @author  Romain Cottard
 */
class Generator extends Eurekon\AbstractScript
{
    /**
     * Generator constructor.
     */
    public function __construct()
    {
        $this->setDescription('Password generator');
        $this->setExecutable(true);
    }

    /**
     * {@inheritdoc}
     */
    public function help()
    {
        $help = new Eurekon\Help('...');
        $help->addArgument('g', 'generate', 'Generate password', false, false);
        $help->addArgument('l', 'length', 'Password length', true, false);
        $help->addArgument('a', 'ratio-alpha', 'Alphabetic latin characters ratio', true, false);
        $help->addArgument('n', 'ratio-numeric', 'Numeric characters ratio', true, false);
        $help->addArgument('o', 'ratio-other', 'Other characters ratio', true, false);

        $help->display();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $argument = Eurekon\Argument\Argument::getInstance();

        $doGenerate = $argument->has('generate');

        $password = new Password();
        if ($doGenerate) {
            $length  = $argument->get('l', 'length', 16);
            $alpha   = $argument->get('a', 'ratio-alpha', 0.6);
            $numeric = $argument->get('n', 'ratio-numeric', 0.2);
            $other   = $argument->get('o', 'ratio-other', 0.2);
            $password->generate($length, $alpha, $numeric, $other);
        } else {
            Eurekon\IO\Out::std('Type your password: ', '');
            $plain = trim(fgets(STDIN));
            if (empty($plain)) {
                throw new \RuntimeException('Empty password');
            }
            $password->setPlain($plain);
        }

        $password->hash();

        Eurekon\IO\Out::std('');
        Eurekon\IO\Out::std('Plain: ' . $password->getPlain());
        Eurekon\IO\Out::std('Hash:  ' . $password->getHash());
    }

}
