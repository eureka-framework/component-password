<?php

/*
 * Copyright (c) Romain Cottard
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eureka\Component\Password\Script;

use Eureka\Component\Console;
use Eureka\Component\Console\Option\Option;
use Eureka\Component\Console\Option\Options;
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

        $this->initOptions(
            (new Options())
                ->add(
                    new Option(
                        shortName:   'g',
                        longName:    'generate',
                        description: 'Generate password',
                    )
                )
                ->add(
                    new Option(
                        shortName:   'l',
                        longName:    'length',
                        description: 'Password length',
                        hasArgument: true,
                        default:     16,
                    )
                )
                ->add(
                    new Option(
                        shortName:   'a',
                        longName:    'ratio-alpha',
                        description: 'Alphabetic latin characters ratio',
                        hasArgument: true,
                        default:     0.6,
                    )
                )
                ->add(
                    new Option(
                        shortName:   'n',
                        longName:    'ratio-numeric',
                        description: 'Numeric characters ratio',
                        hasArgument: true,
                        default:     0.2,
                    )
                )
                ->add(
                    new Option(
                        shortName:   'o',
                        longName:    'ratio-other',
                        description: 'Other characters ratio',
                        hasArgument: true,
                        default:     0.2,
                    )
                )
        );
    }

    /**
     * @return void
     */
    public function help(): void
    {
        (new Console\Help(self::class, $this->declaredOptions(), $this->output(), $this->options()))
            ->display()
        ;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        $doGenerate = (bool) $this->options()->value('g', 'generate');

        if ($doGenerate) {
            $length  = (int) $this->options()->value('l', 'length');
            $alpha   = (float) $this->options()->value('a', 'ratio-alpha');
            $numeric = (float) $this->options()->value('n', 'ratio-numeric');
            $other   = (float) $this->options()->value('o', 'ratio-other');
            $password = (new PasswordGenerator(new StringGenerator()))->generate($length, $alpha, $numeric, $other);
        } else {
            $this->output()->write('Type your password: ');
            $plain = trim((string) fgets(STDIN));
            if (empty($plain)) {
                throw new \UnexpectedValueException('Empty password');
            }
            $password = new Password($plain);
        }

        $password->hash();

        $this->output()->writeln('');
        $this->output()->writeln('Plain: ' . $password->getPlain());
        $this->output()->writeln('Hash:  ' . $password->getHash());
    }
}
