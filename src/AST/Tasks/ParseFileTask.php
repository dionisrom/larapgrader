<?php

declare(strict_types=1);

namespace Larapgrader\AST\Tasks;

use Amp\Cancellation;
use Amp\Parallel\Worker\Task;
use Amp\Sync\Channel;
use Larapgrader\AST\AstParser;

/**
 * Worker task to parse a single PHP file into structured AST output.
 *
 * @implements Task<array<string, mixed>|null, mixed, mixed>
 */
class ParseFileTask implements Task
{
    public function __construct(private readonly string $filePath)
    {
    }

    public function run(Channel $channel, Cancellation $cancellation): mixed
    {
        $parser = AstParser::createDefault();

        return $parser->parseFile($this->filePath);
    }
}
