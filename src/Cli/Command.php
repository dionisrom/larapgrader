<?php

declare(strict_types=1);

namespace Larapgrader\Cli;

use Larapgrader\Contracts\CliCommandInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Concrete implementation of CliCommandInterface.
 * 
 * @stub For MVP — to be fully implemented in future stories
 */
class Command implements CliCommandInterface
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        return 0;
    }
}
