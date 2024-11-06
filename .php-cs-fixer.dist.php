<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
    ->exclude('node_modules')
    ->exclude('vendor')
;

return (new PhpCsFixer\Config())
    ->setParallelConfig(PhpCsFixer\Runner\Parallel\ParallelConfigFactory::detect())
    ->setRules([
        '@PER-CS2.0' => true,
        '@PhpCsFixer' => true,
        'phpdoc_align' => ['align' => 'left'],
    ])
    ->setFinder($finder)
;
