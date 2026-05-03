<?php

declare(strict_types=1);

namespace Larapgrader\Exceptions;

/**
 * Exception thrown when PHP syntax parsing fails.
 * 
 * Used by AstParser when nikic/php-parser encounters
 * invalid PHP syntax in a file.
 */
class ParsingException extends LarapgraderException
{
    /**
     * Constructor.
     * 
     * @param string $message Error message
     * @param int $code Error code
     * @param \Throwable|null $previous Previous exception
     */
    public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
