<?php

declare(strict_types=1);

namespace Larapgrader\CLI;

use Larapgrader\Contracts\CliCommandInterface;
use Larapgrader\Contracts\OnboardingWizardInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Concrete implementation of CliCommandInterface.
 * 
 * @stub For MVP — to be fully implemented in future stories
 */
class CliCommand implements CliCommandInterface
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        // Check if this is a first run
        $wizard = $this->getOnboardingWizard($input, $output);
        
        if ($wizard->isFirstRun()) {
            $output->writeln('<comment>First time? Let\'s set things up...</comment>');
            $wizard->runWizard();
        }

        // Main command logic will be implemented in future stories
        return 0;
    }

    private function getOnboardingWizard(InputInterface $input, OutputInterface $output): OnboardingWizardInterface
    {
        // In a fully wired application, this would come from the service container
        return new \Larapgrader\Onboarding\FirstRunWizard($input, $output);
    }
}
