# Just a PHP CS Fixer rule set

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
