# component-password

[![Current version](https://img.shields.io/packagist/v/eureka/component-password.svg?logo=composer)](https://packagist.org/packages/eureka/component-password)
[![Supported PHP version](https://img.shields.io/static/v1?logo=php&label=PHP&message=7.4%20-%208.2&color=777bb4)](https://packagist.org/packages/eureka/component-password)
![CI](https://github.com/eureka-framework/component-password/workflows/CI/badge.svg)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=eureka-framework_component-password&metric=alert_status)](https://sonarcloud.io/dashboard?id=eureka-framework_component-password)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=eureka-framework_component-password&metric=coverage)](https://sonarcloud.io/dashboard?id=eureka-framework_component-password)


Generate, hash & verify secure password.

## Usage

### Password Generatorgit s
```php
<?php

use Eureka\Component\Password\PasswordGenerator;
use Eureka\Component\Password\StringGenerator;

//~ Use service generator
$length  = 16;  // default
$alpha   = 0.6; // default
$numeric = 0.2; // default
$special = 0.2; // default

$generator = new PasswordGenerator(
    new StringGenerator()
);

$password = $generator->generate($length, $alpha, $numeric, $special);

echo $password->getPlain() . PHP_EOL;
echo $password->getHash() . PHP_EOL;
```

### Password

```php
<?php

use Eureka\Component\Password\Password;

//~ Just define password
$password = new Password('mySecretPassword');

echo $password->getHash() . PHP_EOL;
echo $password->getPlain() . PHP_EOL;

```

### PasswordChecker

```php
<?php

use Eureka\Component\Password\PasswordChecker;

//~ Just define password
$passwordChecker = new PasswordChecker();

$passwordPlain = 'mypassword'; // From login form 
$passwordHash  = '...';        // Retrieved from db for example
echo 'Is valid password: ' . $passwordChecker->verify($passwordPlain, $passwordHash) . PHP_EOL;

```

### Script - Password Generator

```bash
~$ vendor/bin/console Password/Script/Generator --help

 *** RUN - Password\Script\Generator - HELP ***

Use    : bin/console ... [OPTION]...
OPTIONS:
  -h,     --help                        Reserved - Display Help
  -g,     --generate                    Generate password
  -l ARG, --length=ARG                  Password length
  -a ARG, --ratio-alpha=ARG             Alphabetic latin characters ratio
  -n ARG, --ratio-numeric=ARG           Numeric characters ratio
  -o ARG, --ratio-other=ARG             Other characters ratio

 *** END SCRIPT - Time taken: 0.07s ***
```
## Composer
composer require "eureka/component-password"

## Installation

You can install the component (for testing) with the following command:
```bash
make install
```

## Update

You can update the component (for testing) with the following command:
```bash
make update
```


## Testing

You can test the component with the following commands:
```bash
make phpcs
make tests
make testdox
```
