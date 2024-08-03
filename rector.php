<?php declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    // uncomment to reach your current PHP version
    ->withPhpSets(php82: true)

    // register single rule
    ->withRules([
        //LevelSetList::UP_TO_PHP_83,
        //TypedPropertyFromStrictConstructorRector::class
    ])

    // here we can define, what prepared sets of rules will be applied
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true
    )
    //->withTypeCoverageLevel(0)
;
