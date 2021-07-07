<?php

const RISKY = true;

$finder = PhpCsFixer\Finder::create()->in(__DIR__)->exclude('rules');

/** @var \PhpCsFixer\Config $config */
$config = require __DIR__.'/main.php';

return $config;
