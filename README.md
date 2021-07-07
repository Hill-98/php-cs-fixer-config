# Just a PHP CS Fixer rule set

<a href="https://packagist.org/packages/hill-98/php-cs-fixer-config"><img alt="Packagist Version" src="https://img.shields.io/packagist/v/hill-98/php-cs-fixer-config"></a>
<a href="https://packagist.org/packages/hill-98/php-cs-fixer-config/stats"><img alt="Packagist Downloads" src="https://img.shields.io/packagist/dt/hill-98/php-cs-fixer-config"></a>
<a href="https://github.com/Hill-98/php-cs-fixer-config/blob/master/LICENSE"><img alt="MIT" src="https://img.shields.io/github/license/Hill-98/php-cs-fixer-config"></a>
<a href="https://github.com/Hill-98/php-cs-fixer-config/actions/workflows/phpunit.yml"><img alt="PHPUnit Test" src="https://github.com/Hill-98/php-cs-fixer-config/actions/workflows/phpunit.yml/badge.svg"></a>

Based on the [PSR12](https://cs.symfony.com/doc/ruleSets/PSR12.html) rule set to expand

## Install

`composer require hill-98/php-cs-fixer-config --dev`

You can also go to the [releases](https://github.com/Hill-98/php-cs-fixer-config/releases) of the latest version

## Usage

**`.php-cs-fixer.php`**:
```php
<?php

// Allow Risky rules
// const RISKY = true;

$finder = PhpCsFixer\Finder::create()
    ->exclude('somedir')
    ->notPath('src/Symfony/Component/Translation/Tests/fixtures/resources.php')
    ->in(__DIR__);

// These rules will be merged and set ($rules must be array)
$rules = [];

// Extended $config ($config must be \PhpCsFixer\ConfigInterface)
// $config = new PhpCsFixer\Config();

/** @var \PhpCsFixer\Config $config */
$config = require __DIR__.'/vendor/hill-98/php-cs-fixer-config/main.php';

// Auto set $finder ($finder must be iterable)
// $config->setFinder($finder); // Don't repeat SET

return $config;
```
