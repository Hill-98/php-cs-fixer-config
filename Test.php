<?php

declare(strict_types=1);

use PhpCsFixer\ConfigurationException\InvalidForEnvFixerConfigurationException;
use PhpCsFixer\Fixer\ConfigurableFixerInterface;
use PhpCsFixer\Config;
use PhpCsFixer\ConfigInterface;
use PhpCsFixer\Finder;
use PhpCsFixer\FixerFactory;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    /**
     * @dataProvider provideAllRules
     */
    public function testIfAllRules(string $setName, string $ruleName, array | bool $ruleConfig): void
    {
        $factory = new FixerFactory();
        $factory->registerBuiltInFixers();

        $fixers = [];

        foreach ($factory->getFixers() as $fixer) {
            $fixers[$fixer->getName()] = $fixer;
        }

        $this->assertArrayHasKey($ruleName, $fixers, sprintf('RuleSet "%s" contains unknown rule.', $setName));

        if (true === $ruleConfig) {
            return; // rule doesn't need configuration.
        }

        $fixer = $fixers[$ruleName];
        $this->assertInstanceOf(ConfigurableFixerInterface::class, $fixer, sprintf('RuleSet "%s" contains configuration for rule "%s" which cannot be configured.', $setName, $ruleName));

        try {
            $fixer->configure($ruleConfig); // test fixer accepts the configuration
        } catch (InvalidForEnvFixerConfigurationException) {
            // ignore
        }
    }

    public function testConfig(): void
    {
        /** @var ConfigInterface $config */
        $finder = Finder::create()->in(__DIR__);
        $rules = ['echo_tag_syntax' => true];
        $config = require __DIR__.'/main.php';
        $this->assertInstanceOf(ConfigInterface::class, $config, 'Not ConfigInterdace implement');
        $this->assertFalse($config->getRiskyAllowed(), 'RiskyAllowed already set');
        $this->assertSame($config->getFinder(), $finder, 'Not set Finder');
        $this->assertTrue($config->getRules()['echo_tag_syntax'], 'No merge rules');
        unset($config, $finder, $rules);

        $config = new Config();
        $config->setLineEnding("\r\n");
        $config = require __DIR__.'/main.php';
        $this->assertSame($config->getLineEnding(), "\r\n", 'No extend $config');
        unset($config);

        define('RISKY', true);
        $config = require __DIR__.'/main.php';
        $this->assertTrue($config->getRiskyAllowed(), 'No set RiskyAllowed');
        unset($config);

        $config = require __DIR__.'/main.php';
        $this->assertTrue($config->getRules()['@PSR12'], 'config rules error');
    }

    public function provideAllRules(): array
    {
        $generalRules = require __DIR__.'/rules/general.php';
        $riskyRules = require __DIR__.'/rules/risky.php';
        return [
            ...array_map(static fn (array | bool $value, string $key) => ['general', $key, $value], $generalRules, array_keys($generalRules)),
            ...array_map(static fn (array | bool $value, string $key) => ['risky', $key, $value], $riskyRules, array_keys($riskyRules)),
        ];
    }
}
