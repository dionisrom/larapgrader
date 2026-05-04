<?php

declare(strict_types=1);

namespace Larapgrader\AST;

use Larapgrader\Services\SymbolIndexService;

/**
 * Backward-compatible alias for SymbolIndexService.
 *
 * @deprecated Prefer Larapgrader\Services\SymbolIndexService.
 */
class SymbolIndex extends SymbolIndexService
{
}
