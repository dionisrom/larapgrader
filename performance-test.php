<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Larapgrader\Confidence\AstAnalysis;
use Larapgrader\Confidence\ConfidenceFactors;
use Larapgrader\Confidence\ConfidenceScore;
use Larapgrader\Confidence\Rule;
use Larapgrader\Contracts\AuditTrailInterface;
use Larapgrader\Contracts\SymbolIndexInterface;
use Larapgrader\Services\ConfidenceScorerService;
use PhpParser\Node\Stmt\Class_;
use Mockery;

// Mock implementations for performance testing
class MockSymbolIndex implements SymbolIndexInterface {
    public function index(array|string $source, ?string $filePath = null): void {}
    public function lookup(string $name, ?string $type = null): ?array { return null; }
    public function getReferences(string $name, ?string $type = null): array { return []; }
    public function persist(string $outputPath): void {}
    public function load(string $inputPath): void {}
    public function search(string $query): array { return []; }
}

class MockAuditTrail implements AuditTrailInterface {
    public function record(string $eventType, array $data = []): void {}
    public function export(?string $format = null): string { return ''; }
}

// Create scorer instance
$symbolIndex = new MockSymbolIndex();
$auditTrail = new MockAuditTrail();
$scorer = new ConfidenceScorerService($symbolIndex, $auditTrail);

// Performance test: score 1000 files
$startTime = \microtime(true);
$fileCount = 1000;
$latencies = [];

for ($i = 0; $i < $fileCount; $i++) {
    $iterationStart = \microtime(true);
    
    // Create test data that varies
    $successCount = ($i % 3 === 0) ? 0 : (($i % 5 === 0) ? 50 : 100);
    $rule = new Rule(
        "pattern.{$i}",
        "Test Pattern {$i}",
        $successCount,
        100,
        'middleware'
    );
    
    $node = \Mockery::mock(Class_::class);
    $node->shouldReceive('getSubNodeNames')->andReturn([]);
    $analysis = new AstAnalysis(
        $node,
        "file{$i}.php",
        $i % 10,  // depth varies 0-9
        ($i % 5) * 2,  // child count varies 0-8
        ['affected_files' => ($i % 50) + 1]  // file count varies 1-50
    );
    
    try {
        $score = $scorer->scoreRule($rule, $analysis, $symbolIndex);
        
        $iterationEnd = \microtime(true);
        $latency = ($iterationEnd - $iterationStart) * 1000;  // Convert to ms
        $latencies[] = $latency;
    } catch (\Exception $e) {
        echo "Error scoring file {$i}: " . $e->getMessage() . "\n";
        exit(1);
    }
}

$endTime = \microtime(true);
$totalTime = ($endTime - $startTime) * 1000;

// Calculate statistics
\sort($latencies);
$minLatency = \min($latencies);
$maxLatency = \max($latencies);
$avgLatency = \array_sum($latencies) / \count($latencies);
$medianLatency = $latencies[(int)(\count($latencies) / 2)];
$p95Latency = $latencies[(int)(\count($latencies) * 0.95)];
$p99Latency = $latencies[(int)(\count($latencies) * 0.99)];

echo "\n=== Performance Validation Report ===\n";
echo "Total files scored: {$fileCount}\n";
echo "Total time: " . \round($totalTime, 2) . " ms\n";
echo "\n=== Latency Statistics ===\n";
echo "Min latency: " . \round($minLatency, 3) . " ms\n";
echo "Max latency: " . \round($maxLatency, 3) . " ms\n";
echo "Average latency: " . \round($avgLatency, 3) . " ms\n";
echo "Median latency: " . \round($medianLatency, 3) . " ms\n";
echo "P95 latency: " . \round($p95Latency, 3) . " ms\n";
echo "P99 latency: " . \round($p99Latency, 3) . " ms\n";

// Check performance requirement: <100ms per file
$requirement = 100;
$exceeds = \array_filter($latencies, function ($latency) use ($requirement) {
    return $latency >= $requirement;
});

echo "\n=== Performance Requirement Check ===\n";
echo "Requirement: All files scored in < {$requirement} ms\n";
echo "Files exceeding requirement: " . \count($exceeds) . " / {$fileCount}\n";

if (\count($exceeds) === 0) {
    echo "✓ PASS: All {$fileCount} files scored within {$requirement} ms limit\n";
    exit(0);
} else {
    $excessPercentage = (\count($exceeds) / $fileCount) * 100;
    echo "✗ FAIL: {$excessPercentage}% of files exceed {$requirement} ms limit\n";
    echo "  Max latency: " . \round($maxLatency, 3) . " ms\n";
    exit(1);
}
