<?php

$__config = $config ?? new PhpCsFixer\Config();

$__rules = array_merge(['@PSR12' => true], require __DIR__.'/rules/general.php');

if (defined('RISKY') && constant('RISKY') === true) {
    $__rules = array_merge($__rules, require __DIR__.'/rules/risky.php');
    $__config->setRiskyAllowed(true);
}

if (isset($finder)) {
    $__config->setFinder($finder);
}

$__config->setRules($__rules);

return $__config;
