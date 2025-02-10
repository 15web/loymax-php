<?php

declare(strict_types=1);

use ComposerUnused\ComposerUnused\Configuration\Configuration;
use ComposerUnused\ComposerUnused\Configuration\NamedFilter;

return static function (Configuration $config): Configuration {
    $config
        ->addNamedFilter(NamedFilter::fromString('phpdocumentor/reflection-docblock'))
        ->addNamedFilter(NamedFilter::fromString('symfony/property-access'));

    return $config;
};
