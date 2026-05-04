<?php

declare(strict_types=1);

namespace Larapgrader\Confidence;

use PhpParser\Node;

/**
 * Value object representing an AST node analysis context.
 *
 * Wraps a PHP parser AST node with additional context information
 * for confidence scoring calculations.
 * Implements PSR-12 coding standard and uses strict types (A19, A20).
 *
 * @since 1.0
 */
class AstAnalysis
{
    /**
     * The PHP parser Node being analyzed.
     *
     * @var Node
     */
    private Node $node;

    /**
     * File path where the node originated.
     *
     * @var string
     */
    private string $filePath;

    /**
     * Depth of the node in the AST tree (root = 0).
     *
     * @var int
     */
    private int $depth;

    /**
     * Number of direct children in the AST.
     *
     * @var int
     */
    private int $childCount;

    /**
     * Additional context metadata.
     *
     * @var array<string, mixed>
     */
    private array $metadata;

    /**
     * Constructor for AstAnalysis value object.
     *
     * @param Node $node The PHP parser AST node
     * @param string $filePath File path where this node originated
     * @param int $depth Depth in the AST tree (root = 0)
     * @param int $childCount Number of direct children
     * @param array<string, mixed> $metadata Additional context (namespace, class name, etc.)
     */
    public function __construct(
        Node $node,
        string $filePath,
        int $depth,
        int $childCount,
        array $metadata = []
    ) {
        $this->node = $node;
        $this->filePath = $filePath;
        $this->depth = $depth;
        $this->childCount = $childCount;
        $this->metadata = $metadata;
    }

    /**
     * Get the AST node.
     *
     * @return Node
     */
    public function getNode(): Node
    {
        return $this->node;
    }

    /**
     * Get the file path.
     *
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * Get the node depth in the AST tree.
     *
     * @return int
     */
    public function getDepth(): int
    {
        return $this->depth;
    }

    /**
     * Get the number of direct children.
     *
     * @return int
     */
    public function getChildCount(): int
    {
        return $this->childCount;
    }

    /**
     * Get metadata value by key.
     *
     * @param string $key Metadata key
     * @param mixed $default Default value if key not found
     *
     * @return mixed
     */
    public function getMetadata(string $key, mixed $default = null): mixed
    {
        return $this->metadata[$key] ?? $default;
    }

    /**
     * Get all metadata.
     *
     * @return array<string, mixed>
     */
    public function getAllMetadata(): array
    {
        return $this->metadata;
    }
}
