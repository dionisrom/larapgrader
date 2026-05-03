<?php

declare(strict_types=1);

namespace Larapgrader\Contracts;

/**
 * Interface for State Registry that persists migration state.
 */
interface StateRegistryInterface
{
    /**
     * Get a value from the state registry.
     *
     * @param string $key The state key
     * @return mixed The stored value or null if not found
     */
    public function get(string $key): mixed;

    /**
     * Set a value in the state registry.
     *
     * @param string $key The state key
     * @param mixed $value The value to store
     * @return void
     */
    public function set(string $key, mixed $value): void;

    /**
     * Delete a value from the state registry.
     *
     * @param string $key The state key
     * @return void
     */
    public function delete(string $key): void;
}
