<?php

declare(strict_types=1);

namespace Larapgrader\Contracts;

/**
 * Interface for onboarding wizard.
 * Handles first-run setup and configuration file generation.
 */
interface OnboardingWizardInterface
{
    /**
     * Detect if this is a first-run (no larapgrader.yaml exists).
     *
     * @return bool
     */
    public function isFirstRun(): bool;

    /**
     * Run the interactive wizard and return collected configuration.
     *
     * @return array<string, mixed> Configuration array to be written to larapgrader.yaml
     */
    public function runWizard(): array;
}
