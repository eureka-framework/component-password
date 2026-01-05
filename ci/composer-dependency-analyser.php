<?php

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

$config = new Configuration();

return $config
    ->addPathToScan(__DIR__ . '/../src', false)
    ->addPathToScan(__DIR__ . '/../scripts', false)
    ->addPathToScan(__DIR__ . '/../tests', true)
    ->ignoreErrorsOnPackage('eureka/component-console', [ErrorType::DEV_DEPENDENCY_IN_PROD])
;
