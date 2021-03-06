<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
    ->exclude('vendor')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@PhpCsFixer' => true,
        '@DoctrineAnnotation' => true,
    ])
    ->setFinder($finder)
    ;
