<?php declare(strict_types=1);

use Arkitect\ClassSet;
use Arkitect\CLI\Config;
use Arkitect\Expression\ForClasses\NotHaveDependencyOutsideNamespace;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Rules\Rule;

return static function (Config $config): void {
    $insideAppAllowedDependecies = [
        'DateTimeImmutable', 'DateInterval', 'Psr\Clock\ClockInterface', 'RuntimeException',
    ];

    $HexAppClassSet = ClassSet::fromDir(__DIR__ . '/src');

    $rules = [];

    $rules[] = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('Bluezone\Core'))
        ->should(new NotHaveDependencyOutsideNamespace('Bluezone\Core', $insideAppAllowedDependecies))
        ->because('we want protect our \'Inside App\' boundary.');

    $config
        ->add($HexAppClassSet, ...$rules);
};
