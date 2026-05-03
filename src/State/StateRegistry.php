<?php

declare(strict_types=1);

namespace Larapgrader\State;

use Larapgrader\Contracts\StateRegistryInterface;

/**
 * Concrete implementation of StateRegistryInterface.
 * 
 * @stub For MVP — to be fully implemented in future stories
 */
class StateRegistry implements StateRegistryInterface
{
    public function get(string $key): mixed
    {
        return null;
    }

    public function set(string $key, mixed $value): void
    {
    }

    public function delete(string $key): void
    {
    }
}
