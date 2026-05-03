<?php

declare(strict_types=1);

namespace Larapgrader\LLM;

use Larapgrader\Contracts\OllamaProviderInterface;

/**
 * Concrete implementation of OllamaProviderInterface.
 *
 * @stub For MVP — to be fully implemented in future stories
 */
class OllamaProvider implements OllamaProviderInterface
{
    public function query(string $prompt): string
    {
        return '';
    }

    /**
     * @param array<mixed> $context
     */
    public function explain(array $context): string
    {
        return '';
    }
}
