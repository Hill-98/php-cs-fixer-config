<?php

declare(strict_types=1);

$__config = isset($config) && $config instanceof \PhpCsFixer\ConfigInterface ? $config : new \PhpCsFixer\Config();

$__rules = array_merge(['@PSR12' => true], require __DIR__.'/rules/general.php');

if (defined('RISKY') && constant('RISKY') === true) {
    $__rules = array_merge($__rules, require __DIR__.'/rules/risky.php');
    $__config->setRiskyAllowed(true);
}

if (isset($finder) && is_iterable($finder)) {
    $__config->setFinder($finder);
}

$__config->setRules(array_merge($__rules, isset($rules) && is_array($rules) ? $rules : []));

return $__config;
