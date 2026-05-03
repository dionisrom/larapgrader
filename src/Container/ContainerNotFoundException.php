<?php

declare(strict_types=1);

namespace Larapgrader\Container;

use Psr\Container\NotFoundExceptionInterface;

class ContainerNotFoundException extends \RuntimeException implements NotFoundExceptionInterface
{
    public function __construct(string $id)
    {
        parent::__construct("Service '{$id}' not found in container");
    }
}
