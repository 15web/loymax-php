<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

$finder = (new Finder())
    ->in([
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->append([__FILE__]);

return (new Config())
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setCacheFile(__DIR__.'/cache/php-cs-fixer.cache')
    ->setRiskyAllowed(true)
    ->setRules([
        '@PER-CS' => true,
        '@PER-CS:risky' => true,
        '@PHP80Migration:risky' => true,
        '@PHP82Migration' => true,
        '@PhpCsFixer' => true,
        '@PhpCsFixer:risky' => true,
        '@PHPUnit100Migration:risky' => true,
        'string_implicit_backslashes' => false,
        'final_class' => true,
        'final_public_method_for_abstract_class' => true,
        'date_time_immutable' => true,
        'nullable_type_declaration_for_default_null_value' => true,
        'self_static_accessor' => true,
        'static_lambda' => true,
        'yoda_style' => ['equal' => false, 'identical' => false, 'less_and_greater' => false],
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'binary_operator_spaces' => true,
        'ordered_imports' => true,
        'return_assignment' => false,
        'phpdoc_to_comment' => [
            'ignored_tags' => [
                'psalm-suppress',
                'phpstan-ignore-next-line',
                'var',
            ],
        ],
        'global_namespace_import' => ['import_classes' => true],
        'phpdoc_align' => ['align' => 'left'],
        'phpdoc_line_span' => true,
        'phpdoc_summary' => false,
        'phpdoc_types_order' => ['null_adjustment' => 'always_last'],
        'php_unit_test_class_requires_covers' => false,
    ])
    ->setFinder($finder);
