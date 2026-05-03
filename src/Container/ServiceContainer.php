<?php

declare(strict_types=1);

namespace Larapgrader\Container;

use DI\Container as DIContainer;
use DI\ContainerBuilder;
use InvalidArgumentException;
use Psr\Container\ContainerInterface;

/**
 * PSR-11 compliant service container using PHP-DI.
 * (A6: Use PHP-DI for Service Container)
 */
class ServiceContainer implements ContainerInterface
{
    private DIContainer $container;

    /**
     * @var array<string, mixed>
     */
    private array $bindings = [];

    /**
     * Constructor - initializes PHP-DI container.
     */
    public function __construct()
    {
        $this->container = (new ContainerBuilder())
            ->useAutowiring(true)
            ->build();
    }

    /**
     * Get a service from the container.
     *
     * @param string $id The service identifier (usually FQCN)
     * @throws \Psr\Container\NotFoundExceptionInterface If service not found
     * @return mixed The service instance
     */
    public function get(string $id): mixed
    {
        if ('' === $id) {
            throw new ContainerNotFoundException($id);
        }

        if (isset($this->bindings[$id])) {
            $binding = $this->bindings[$id];

            // Class-string bindings are lazily resolved to instances.
            if (is_string($binding) && class_exists($binding)) {
                return $this->container->get($binding);
            }

            return $binding;
        }

        if (!$this->container->has($id)) {
            throw new ContainerNotFoundException($id);
        }

        return $this->container->get($id);
    }

    /**
     * Check if a service exists in the container.
     *
     * @param string $id The service identifier
     * @return bool True if service exists
     */
    public function has(string $id): bool
    {
        if ('' === $id) {
            return false;
        }

        return isset($this->bindings[$id]) || $this->container->has($id);
    }

    /**
     * Set (bind) a service in the container.
     *
     * @param string $id The service identifier
     * @param mixed $value The service instance or factory
     */
    public function set(string $id, mixed $value): void
    {
        if ('' === $id) {
            throw new InvalidArgumentException('Service id must be a non-empty string.');
        }

        $this->bindings[$id] = $value;
    }
}
