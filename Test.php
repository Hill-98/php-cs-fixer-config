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
        $config = require __DIR__.'/main.php';
        $this->assertInstanceOf(ConfigInterface::class, $config, 'config is not ConfigInterface');
        $this->assertFalse($config->getRiskyAllowed(), 'config has set Riskyallowed');
        unset($config);

        $config = new Config();
        $config->setLineEnding("\r\n");
        $config = require __DIR__.'/main.php';
        $this->assertSame($config->getLineEnding(), "\r\n", 'config does not expand the current config');
        unset($config);

        $finder = Finder::create()->in(__DIR__);
        $config = require __DIR__.'/main.php';
        $this->assertSame($config->getFinder(), $finder, 'config does not set up Finder');
        unset($config, $finder);

        define('RISKY', true);
        $config = require __DIR__.'/main.php';
        $this->assertTrue($config->getRiskyAllowed(), 'config does not set up RiskyAllowed');
        unset($config);

        $config = require __DIR__.'/main.php';
        $this->assertArrayHasKey('@PSR12', $config->getRules(), 'config rules error');
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
