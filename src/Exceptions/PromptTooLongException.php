<?php

declare(strict_types=1);

namespace Larapgrader\Exceptions;

use InvalidArgumentException;

/**
 * Exception thrown when prompt exceeds the maximum allowed length.
 *
 * Enforces NFR6 (Code snippet filtering): OllamaCliService prevents
 * transmission of oversized prompts (>50KB).
 */
class PromptTooLongException extends InvalidArgumentException
{
    private int $promptLength = 0;

    public function __construct(
        int $promptLength,
        int $maxLength = 50000,
        string $message = ''
    ) {
        $this->promptLength = $promptLength;

        if (empty($message)) {
            $message = sprintf(
                'Prompt exceeds %d byte limit (got %d bytes). '
                . 'Caller must filter code snippets to essential context only.',
                $maxLength,
                $promptLength
            );
        }

        parent::__construct($message);
    }

    public function getPromptLength(): int
    {
        return $this->promptLength;
    }
}
