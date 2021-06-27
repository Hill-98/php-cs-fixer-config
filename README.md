# Just a PHP CS Fixer rule set

<a href="https://github.com/Hill-98/php-cs-fixer-config/blob/master/LICENSE"><img alt="MIT" src="https://img.shields.io/github/license/Hill-98/php-cs-fixer-config"></a>
<a href="https://packagist.org/packages/hill-98/php-cs-fixer-config"><img alt="PHP Version" src="https://img.shields.io/packagist/php-v/hill-98/php-cs-fixer-config"></a>
<a href="https://packagist.org/packages/hill-98/php-cs-fixer-config"><img alt="Packagist Downloads" src="https://img.shields.io/packagist/dt/Hill-98/php-cs-fixer-config"></a>
<img alt="Packagist Version" src="https://img.shields.io/packagist/v/Hill-98/php-cs-fixer-config">

Based on the [PSR12](https://cs.symfony.com/doc/ruleSets/PSR12.html) rule set to expand

## Install

`composer require hill-98/php-cs-fixer-config --dev`

You can also go to the [releases](https://github.com/Hill-98/php-cs-fixer-config/releases) of the latest version

## Usage

**`.php-cs-fixer.php`**:
```php
<?php

// define('RISKY', true); // Allow Risky rules

$finder = PhpCsFixer\Finder::create()
    ->exclude('somedir')
    ->notPath('src/Symfony/Component/Translation/Tests/fixtures/resources.php')
    ->in(__DIR__);


/** @var \PhpCsFixer\Config $config */
$config = require __DIR__.'/vendor/hill-98/php-cs-fixer-config/main.php';

// If there is a $ finder variable, you can omit the following.
// $config->setFinder($finder);

return $config;
```
