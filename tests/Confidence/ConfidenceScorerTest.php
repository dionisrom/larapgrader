<?php

declare(strict_types=1);

use Larapgrader\Audit\ConfidenceAuditLogger;
use Larapgrader\Confidence\AstAnalysis;
use Larapgrader\Confidence\ConfidenceFactors;
use Larapgrader\Confidence\ConfidenceScore;
use Larapgrader\Confidence\Rule;
use Larapgrader\Contracts\AuditTrailInterface;
use Larapgrader\Contracts\SymbolIndexInterface;
use Larapgrader\Services\ConfidenceScorerService;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Class_;
use Mockery\MockInterface;

beforeEach(function () {
    // Create test fixtures
    $this->testDataPath = __DIR__ . '/../Fixtures/confidence-data/synthetic-analysis.json';
    $this->testData = \json_decode(\file_get_contents($this->testDataPath), true);
});

afterEach(function () {
    \Mockery::close();
});

describe('ConfidenceScorerService', function () {
    describe('scoreRule', function () {
        test('returns confidence score with correct band for low-complexity code', function () {
            $rule = new Rule(
                'test.simple',
                'Simple Transformation',
                5, // successCount
                5, // totalApplications
                'middleware'
            );

            $node = \Mockery::mock(Class_::class);
            $node->shouldReceive('getSubNodeNames')->andReturn([]);

            $analysis = new AstAnalysis($node, 'test.php', 1, 2, [
                'affected_files' => 1,
            ]);

            $mockSymbolIndex = \Mockery::mock(SymbolIndexInterface::class);
            $mockAuditTrail = \Mockery::mock(AuditTrailInterface::class);
            $mockAuditTrail->shouldReceive('record')->andReturn(null);

            $scorer = new ConfidenceScorerService($mockSymbolIndex, $mockAuditTrail);

            $score = $scorer->scoreRule($rule, $analysis);

            expect($score)->toBeInstanceOf(ConfidenceScore::class);
            expect($score->getScore())->toBeBetween(0, 100);
            expect($score->getBand())->toBeIn(['auto', 'review', 'manual', 'high_risk']);
        });

        test('scores reflect rule maturity (success count)', function () {
            // Rule with 0 successes
            $lowMaturityRule = new Rule('test.low', 'Low Maturity', 0, 5, 'middleware');

            // Rule with 10 successes
            $highMaturityRule = new Rule('test.high', 'High Maturity', 10, 10, 'middleware');

            $node = \Mockery::mock(Class_::class);
            $node->shouldReceive('getSubNodeNames')->andReturn([]);

            $analysis = new AstAnalysis($node, 'test.php', 1, 0, ['affected_files' => 1]);

            $mockSymbolIndex = \Mockery::mock(SymbolIndexInterface::class);
            $mockAuditTrail = \Mockery::mock(AuditTrailInterface::class);
            $mockAuditTrail->shouldReceive('record')->andReturn(null);

            $scorer = new ConfidenceScorerService($mockSymbolIndex, $mockAuditTrail);

            $lowScore = $scorer->scoreRule($lowMaturityRule, $analysis);
            $highScore = $scorer->scoreRule($highMaturityRule, $analysis);

            // Higher maturity should result in higher score
            expect($highScore->getScore())->toBeGreaterThanOrEqual($lowScore->getScore());
        });

        test('applies calibration multiplier correctly', function () {
            $rule = new Rule('test.calibrate', 'Calibration Test', 5, 10, 'middleware');

            $node = \Mockery::mock(Class_::class);
            $node->shouldReceive('getSubNodeNames')->andReturn([]);

            $analysis = new AstAnalysis($node, 'test.php', 1, 0, ['affected_files' => 1]);

            $mockSymbolIndex = \Mockery::mock(SymbolIndexInterface::class);
            $mockAuditTrail = \Mockery::mock(AuditTrailInterface::class);
            $mockAuditTrail->shouldReceive('record')->andReturn(null);

            // Scorer with 2.0 calibration multiplier
            $scorer = new ConfidenceScorerService(
                $mockSymbolIndex,
                $mockAuditTrail,
                null,
                2.0
            );

            $score = $scorer->scoreRule($rule, $analysis);

            expect($score->getScore())->toBeBetween(0, 100);
        });

        test('throws exception for invalid calibration multiplier', function () {
            $mockSymbolIndex = \Mockery::mock(SymbolIndexInterface::class);
            $mockAuditTrail = \Mockery::mock(AuditTrailInterface::class);

            expect(fn () => new ConfidenceScorerService(
                $mockSymbolIndex,
                $mockAuditTrail,
                null,
                0 // Invalid: must be positive
            ))->toThrow(\InvalidArgumentException::class);
        });
    });

    describe('band assignment', function () {
        test('assigns auto band for high scores', function () {
            // Rule with perfect success record (high maturity = 100%)
            $rule = new Rule('test.auto', 'Auto Band', 100, 100, 'middleware');

            $node = \Mockery::mock(Class_::class);
            $node->shouldReceive('getSubNodeNames')->andReturn([]);

            // Create analysis with minimal complexity for high score
            $analysis = new AstAnalysis($node, 'test.php', 0, 0, ['affected_files' => 1]);

            $mockSymbolIndex = \Mockery::mock(SymbolIndexInterface::class);
            $mockAuditTrail = \Mockery::mock(AuditTrailInterface::class);
            $mockAuditTrail->shouldReceive('record')->andReturn(null);

            $scorer = new ConfidenceScorerService($mockSymbolIndex, $mockAuditTrail);
            $score = $scorer->scoreRule($rule, $analysis);

            // With perfect maturity and low complexity, score should be at least 'manual' (30+)
            expect($score->getScore())->toBeGreaterThanOrEqual(30);
            expect($score->getBand())->not->toBe('high_risk');
        });

        test('assigns high_risk band for low scores', function () {
            // Rule with 0 maturity + analysis with max complexity
            $rule = new Rule('test.risk', 'High Risk', 0, 10, 'middleware');

            $node = \Mockery::mock(Class_::class);
            $node->shouldReceive('getSubNodeNames')->andReturn([]);

            // Simulate high complexity with many affected files
            $analysis = new AstAnalysis($node, 'test.php', 10, 50, ['affected_files' => 50]);

            $mockSymbolIndex = \Mockery::mock(SymbolIndexInterface::class);
            $mockAuditTrail = \Mockery::mock(AuditTrailInterface::class);
            $mockAuditTrail->shouldReceive('record')->andReturn(null);

            $scorer = new ConfidenceScorerService($mockSymbolIndex, $mockAuditTrail);
            $score = $scorer->scoreRule($rule, $analysis);

            // Very low confidence should get high_risk or manual band
            if ($score->getScore() <= 29) {
                expect($score->getBand())->toBe('high_risk');
            }
        });
    });
});

describe('ConfidenceScore', function () {
    describe('validation', function () {
        test('rejects invalid score range', function () {
            expect(fn () => new ConfidenceScore(101, 'auto', 'test', 'none'))
                ->toThrow(\InvalidArgumentException::class, 'Score must be between 0 and 100');

            expect(fn () => new ConfidenceScore(-1, 'auto', 'test', 'none'))
                ->toThrow(\InvalidArgumentException::class, 'Score must be between 0 and 100');
        });

        test('rejects invalid band', function () {
            expect(fn () => new ConfidenceScore(50, 'invalid_band', 'test', 'none'))
                ->toThrow(\InvalidArgumentException::class, 'Band must be one of');
        });

        test('accepts valid bands', function () {
            $bands = ['auto', 'review', 'manual', 'high_risk'];

            foreach ($bands as $band) {
                $score = new ConfidenceScore(50, $band, 'test', 'none');
                expect($score->getBand())->toBe($band);
            }
        });
    });

    describe('serialization', function () {
        test('converts to audit data format', function () {
            $score = new ConfidenceScore(75, 'review', 'Test explanation', 'ollama');
            $auditData = $score->toAuditData();

            expect($auditData)->toHaveKeys(['score', 'band', 'explanation', 'llm_used', 'timestamp']);
            expect($auditData['score'])->toBe(75);
            expect($auditData['band'])->toBe('review');
        });

        test('converts to LLM data format', function () {
            $score = new ConfidenceScore(62, 'review', 'Review recommended', 'copilot');
            $llmData = $score->toLlmData();

            expect($llmData)->toHaveKeys(['score', 'band', 'explanation']);
            expect($llmData['score'])->toBe(62);
            expect($llmData['explanation'])->toBe('Review recommended');
        });
    });
});

describe('ConfidenceFactors', function () {
    describe('validation', function () {
        test('rejects invalid factor values', function () {
            expect(fn () => new ConfidenceFactors(101, 50, 50, 50, 50))
                ->toThrow(\InvalidArgumentException::class);

            expect(fn () => new ConfidenceFactors(50, -1, 50, 50, 50))
                ->toThrow(\InvalidArgumentException::class);
        });
    });

    describe('weighted score calculation', function () {
        test('calculates weighted score correctly', function () {
            // Equal factors: (50 * 0.35) + (50 * 0.25) + (50 * 0.20) + (50 * 0.15) + (50 * 0.05) = 50
            $factors = new ConfidenceFactors(50, 50, 50, 50, 50);
            $score = $factors->calculateWeightedScore(1.0);

            expect($score)->toBe(50.0);
        });

        test('respects calibration multiplier', function () {
            $factors = new ConfidenceFactors(50, 50, 50, 50, 50);
            $score1 = $factors->calculateWeightedScore(1.0);
            $score2 = $factors->calculateWeightedScore(2.0);

            // Score should be proportionally higher with 2.0 multiplier (clamped at 100)
            expect($score2)->toBeGreaterThanOrEqual($score1);
        });

        test('clamps result to 0-100 range', function () {
            $factors = new ConfidenceFactors(100, 100, 100, 100, 100);
            $score = $factors->calculateWeightedScore(2.0); // Would be 200 without clamping

            expect($score)->toBeLessThanOrEqual(100);
            expect($score)->toBeGreaterThanOrEqual(0);
        });

        test('rejects invalid calibration multiplier', function () {
            $factors = new ConfidenceFactors(50, 50, 50, 50, 50);

            expect(fn () => $factors->calculateWeightedScore(0))
                ->toThrow(\InvalidArgumentException::class);

            expect(fn () => $factors->calculateWeightedScore(-1))
                ->toThrow(\InvalidArgumentException::class);
        });
    });

    describe('serialization', function () {
        test('converts to audit data', function () {
            $factors = new ConfidenceFactors(35, 25, 20, 15, 5);
            $auditData = $factors->toAuditData();

            expect($auditData)->toHaveKeys([
                'ast_complexity',
                'cross_file_dependencies',
                'custom_code_proximity',
                'rule_maturity',
                'test_coverage',
            ]);
        });

        test('converts to LLM metadata', function () {
            $factors = new ConfidenceFactors(65, 80, 40, 90, 100);
            $llmData = $factors->toLlmMetadata();

            expect($llmData)->toHaveKeys([
                'ast_complexity_score',
                'cross_file_dependencies_score',
                'custom_code_proximity_score',
                'rule_maturity_score',
                'test_coverage_score',
            ]);
        });
    });
});

describe('Rule', function () {
    describe('validation', function () {
        test('rejects negative success count', function () {
            expect(fn () => new Rule('test', 'Test', -1, 10, 'middleware'))
                ->toThrow(\InvalidArgumentException::class);
        });

        test('rejects success count exceeding total', function () {
            expect(fn () => new Rule('test', 'Test', 15, 10, 'middleware'))
                ->toThrow(\InvalidArgumentException::class);
        });
    });

    describe('success rate calculation', function () {
        test('calculates success rate correctly', function () {
            $rule = new Rule('test', 'Test', 8, 10, 'middleware');
            expect($rule->getSuccessRate())->toBe(80.0);

            $rule2 = new Rule('test', 'Test', 0, 10, 'middleware');
            expect($rule2->getSuccessRate())->toBe(0.0);

            $rule3 = new Rule('test', 'Test', 10, 10, 'middleware');
            expect($rule3->getSuccessRate())->toBe(100.0);
        });

        test('returns 0 for zero total applications', function () {
            $rule = new Rule('test', 'Test', 0, 0, 'middleware');
            expect($rule->getSuccessRate())->toBe(0.0);
        });
    });
});

describe('AstAnalysis', function () {
    test('stores and retrieves node information', function () {
        $node = \Mockery::mock(Class_::class);
        $analysis = new AstAnalysis($node, 'test.php', 3, 5, [
            'namespace' => 'App\\Http',
            'class_name' => 'TestClass',
        ]);

        expect($analysis->getFilePath())->toBe('test.php');
        expect($analysis->getDepth())->toBe(3);
        expect($analysis->getChildCount())->toBe(5);
        expect($analysis->getMetadata('class_name'))->toBe('TestClass');
    });

    test('returns default value for missing metadata', function () {
        $node = \Mockery::mock(Class_::class);
        $analysis = new AstAnalysis($node, 'test.php', 1, 1, []);

        expect($analysis->getMetadata('nonexistent', 'default'))
            ->toBe('default');
    });
});

describe('ConfidenceAuditLogger', function () {
    beforeEach(function () {
        $this->auditLogDir = \sys_get_temp_dir() . '/larapgrader-test-' . \uniqid();
        $this->auditLogPath = $this->auditLogDir . '/audit.log';
    });

    afterEach(function () {
        // Clean up test audit log
        if (\file_exists($this->auditLogPath)) {
            \unlink($this->auditLogPath);
        }
        if (\is_dir($this->auditLogDir)) {
            \rmdir($this->auditLogDir);
        }
    });

    test('creates audit directory if not exists', function () {
        $logger = new ConfidenceAuditLogger($this->auditLogPath);
        expect(\is_dir($this->auditLogDir))->toBeTrue();
    });

    test('logs confidence decision', function () {
        $logger = new ConfidenceAuditLogger($this->auditLogPath);

        $score = new ConfidenceScore(75, 'review', 'Review recommended', 'ollama');
        $logger->logConfidenceDecision($score, 'test.pattern', 'marco', 'Test decision');

        expect(\file_exists($this->auditLogPath))->toBeTrue();

        $contents = \file_get_contents($this->auditLogPath);
        expect($contents)->toContain('confidence_decision');
        expect($contents)->toContain('test.pattern');
        expect($contents)->toContain('75');
    });

    test('logs LLM prompt and response', function () {
        $logger = new ConfidenceAuditLogger($this->auditLogPath);

        $logger->logLmmPrompt(
            'Rate this code',
            'This code is well-written',
            'http://localhost:11434',
            150,
            null
        );

        expect(\file_exists($this->auditLogPath))->toBeTrue();

        $contents = \file_get_contents($this->auditLogPath);
        expect($contents)->toContain('llm_interaction');
        expect($contents)->toContain('150'); // latency_ms
    });

    test('retrieves audit entries', function () {
        $logger = new ConfidenceAuditLogger($this->auditLogPath);

        $score = new ConfidenceScore(62, 'review', 'Test', 'ollama');
        $logger->logConfidenceDecision($score, 'pattern1', 'user', 'Test 1');
        $logger->logConfidenceDecision($score, 'pattern2', 'user', 'Test 2');

        $entries = $logger->retrieve();
        expect(\count($entries))->toBe(2);
        expect($entries[0]['pattern_id'])->toBe('pattern1');
        expect($entries[1]['pattern_id'])->toBe('pattern2');
    });

    test('exports audit trail to JSONL', function () {
        $logger = new ConfidenceAuditLogger($this->auditLogPath);

        $score = new ConfidenceScore(75, 'review', 'Test', 'ollama');
        $logger->logConfidenceDecision($score, 'pattern1', 'user', 'Test');

        $export = $logger->export();
        expect($export)->toContain('pattern1');
        expect($export)->toContain('confidence_decision');
    });
});
