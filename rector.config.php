<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\CodeQuality\Rector\Identical\FlipTypeControlToUseExclusiveTypeRector;
use Rector\CodeQuality\Rector\Identical\SimplifyBoolIdenticalTrueRector;
use Rector\Config\RectorConfig;
use Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitThisCallRector;

return RectorConfig::configure()
    ->withCache(__DIR__.'/cache/rector')
    ->withPaths([
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->withParallel()
    ->withPhpSets(php82: true)
    ->withImportNames(importShortClasses: false)
    ->withTypeCoverageLevel(100)
    ->withDeadCodeLevel(50)
    ->withPreparedSets(
        codeQuality: true,
        privatization: true,
        instanceOf: true,
        earlyReturn: true,
        strictBooleans: true,
        rectorPreset: true,
        phpunitCodeQuality: true,
        phpunit: true,
    )
    ->withSkip([
        InlineConstructorDefaultToPropertyRector::class,
        FlipTypeControlToUseExclusiveTypeRector::class,
        SimplifyBoolIdenticalTrueRector::class,
        PreferPHPUnitThisCallRector::class,
    ]);
