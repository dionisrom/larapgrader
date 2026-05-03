<?php

declare(strict_types=1);

namespace Larapgrader\Contracts;

/**
 * Interface for CLI Commands.
 */
interface CliCommandInterface
{
    /**
     * Execute the CLI command.
     *
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int Exit code
     */
    public function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output): int;
}
