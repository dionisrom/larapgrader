<?php

declare(strict_types=1);

namespace Larapgrader\Onboarding;

use Larapgrader\Contracts\OnboardingWizardInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * FirstRunWizard handles interactive setup for first-time users.
 * Detects first-run state and guides users through initial configuration.
 */
class FirstRunWizard implements OnboardingWizardInterface
{
    public function __construct(
        private InputInterface $input, // @phpstan-ignore-line - reserved for future interactive input
        private OutputInterface $output
    ) {
    }

    /**
     * Detect if this is a first-run (no larapgrader.yaml exists).
     *
     * @return bool
     */
    public function isFirstRun(): bool
    {
        return !file_exists('larapgrader.yaml');
    }

    /**
     * Run the interactive wizard and return collected configuration.
     *
     * @return array<string, mixed> Configuration array to be written to larapgrader.yaml
     */
    public function runWizard(): array
    {
        $this->output->writeln('<info>Welcome to larapgrader! 🎉</info>');
        $this->output->writeln('<info>Let\'s set up your first migration...</info>' . "\n");

        // 1. Get app path
        $appPath = $this->promptForAppPath();

        // 2. Detect PHP version
        $phpVersion = PHP_VERSION;
        $this->output->writeln("<info>✓ Detected PHP $phpVersion</info>");

        // 3. Build configuration
        $config = [
            'app_path' => $appPath,
            'thresholds' => [
                'auto_migrate' => 85,
                'manual_review' => 60,
            ],
            'llm' => [
                'provider' => 'ollama',
                'model' => 'mistral',
            ],
            'post_phase_command' => 'echo "No test command configured"',
        ];

        // 4. Write configuration to YAML
        $this->writeConfigFile($config);

        return $config;
    }

    /**
     * Prompt user for application path.
     *
     * @return string
     */
    private function promptForAppPath(): string
    {
        $default = getcwd();
        
        // Normalize path to forward slashes for cross-platform compatibility
        if ($default !== false) {
            $default = str_replace('\\', '/', $default);
        } else {
            $default = '.';
        }

        // TODO: Implement actual interactive prompt using Symfony Question Helper
        // For now, return the default path
        return $default;
    }

    /**
     * Write configuration to larapgrader.yaml.
     *
     * @param array<string, mixed> $config
     */
    private function writeConfigFile(array $config): void
    {
        $yaml = Yaml::dump($config, 4);
        file_put_contents('larapgrader.yaml', $yaml);
        $this->output->writeln('<info>✓ Created larapgrader.yaml</info>');
    }
}
