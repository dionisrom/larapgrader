<?php

declare(strict_types=1);

namespace Larapgrader\Exceptions;

/**
 * Base exception class for all larapgrader exceptions.
 * 
 * All custom exceptions in the larapgrader project
 * should extend this class for consistent error handling.
 */
class LarapgraderException extends \Exception
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
