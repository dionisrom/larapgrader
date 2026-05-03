---
validation_key: "1-5-validate-ollama-cli"
story_key: "1-5-implement-ollama-cli"
validation_date: "2026-05-03"
validator: "BMad Story Validator (checklist.md framework)"
status: "ready-to-improve"
severity_critical: 7
severity_should: 4
severity_nice: 3
---

# Story 1-5 Validation Report: Implement Ollama CLI wrapper for LLM features

## Executive Summary

**Validation Status: NEEDS IMPROVEMENT** ⚠️

The story file has solid foundational structure with clear acceptance criteria and task breakdown. However, it **lacks sufficient technical depth and architectural context** for a developer to implement confidently without making critical design decisions that could lead to:

- **Wheel reinvention**: ProcessFactory pattern undefined (might duplicate existing utility)
- **File location disasters**: `src/Services/` directory doesn't exist; unclear where OllamaCliService should live  
- **Integration failures**: Container registration not mentioned; developer might forget to wire interface
- **Testing disasters**: Mocking pattern for `symfony/process` not demonstrated
- **Implementation vagueness**: Prompt→CLI translation, error handling, audit format all undefined

**Overall Readiness Score: 65/100** (Target: 80+)

---

## 🔬 SYSTEMATIC VALIDATION ANALYSIS

### Step 1: Load and Understand the Target ✅

**Story File:** `1-5-implement-ollama-cli.md`  
**Story Key:** `1-5-implement-ollama-cli`  
**Epic:** `Epic 1: Project Initialization & Infrastructure`  
**Status:** `ready-for-dev`  

**Requirements Mapping:**
- A4: Use Ollama CLI wrapper (local Mistral) for LLM features ✅
- A9: Use symfony/process for Ollama CLI calls ✅  
- A25: Log all LLM prompts to audit trail before sending ✅
- NFR6: LLM features transmit only selected code snippets ✅
- NFR17: LLM features degrade gracefully if endpoint unreachable ✅

**Workflow Variables Resolved:**
- `implementation_artifacts`: `_bmad-output/implementation-artifacts`
- `planning_artifacts`: `_bmad-output/planning-artifacts`
- `epics_file`: `_bmad-output/planning-artifacts/epics.md` ✅
- `architecture_file`: `_bmad-output/planning-artifacts/architecture.md` ✅
- `prd_file`: `_bmad-output/planning-artifacts/prd.md` ✅
- `previous_story`: `1-4-configure-phpstan` (reference for context continuity)

---

### Step 2: Exhaustive Source Document Analysis

#### 2.1 Epics Deep-Dive ✅

**From epics.md:**
- Story 1.5 explicitly defined: "Implement Ollama CLI wrapper for LLM features (A4, A9)"
- Epic 1 user value: "Marco (engineer) can install larapgrader and run it for the first time with guided setup"
- Epic DoD requires: All tests pass 100% (A26), PSR-12 compliance (A19), PHPStan --level=8 (A29)
- Story scope: MVP phase, no Beta features required

#### 2.2 Architecture Deep-Dive ⚠️ **GAPS FOUND**

**From architecture.md (matched to Story 1.5):**

✅ **Correctly Captured:**
- LLM provider: Ollama local with Mistral model
- Integration: CLI wrapper using `symfony/process`
- Command: `ollama run mistral "prompt"`
- Security: Zero outbound calls (local execution satisfies NFR5)
- Audit: "Log prompt to audit.log before sending to Ollama (NFR9)"
- Error: "Fall back to rule-based explanations if Ollama unavailable"

⚠️ **Missing from Story:**
- **ProcessFactory pattern**: Architecture shows `DI\get(ProcessFactory::class)` in container bindings, but ProcessFactory doesn't exist and story doesn't document this decision
- **Exception hierarchy**: Architecture defines `LLMServiceUnavailableException` but story doesn't mention custom exceptions
- **OllamaProvider vs OllamaCliService**: Architecture shows `OllamaProvider` implementation, but story separately requires `OllamaCliService` wrapping symfony/process (unclear relationship)
- **Command translation**: Story doesn't specify how prompt → `ollama run mistral "..."` conversion works
- **Output parsing**: Architecture shows `.getOutput()` call but story doesn't specify truncation or format

#### 2.3 Previous Story Intelligence ⚠️ **CONTEXT MISSING**

**Story 1.4 (Configure PHPStan)** provides patterns:
- PSR-12 enforcement via php-cs-fixer
- PHPStan Level 8 with specific exclusions
- Pest tests following `test()`/`expect()` syntax
- Mockery ^1.6 for mocking (from Story 1.1)

**Story 1.2 (Service Container)** provides critical patterns:
- All new services must define interfaces in `src/Contracts/`
- Service implementations go in domain-specific folders (e.g., `src/Llm/`)
- **Container registration**: Services must be wired in `ContainerFactory.php`  
  Example: `OllamaProviderInterface::class => OllamaProvider::class`
- **Constructor injection pattern**: Dependencies type-hinted with interface names
- **Testing pattern**: Mockery mocks passed to `ContainerFactory::create([Interface::class => $mock])`

❌ **Story 1.5 Doesn't Document:**
- Whether OllamaCliService needs a dedicated interface or reuses OllamaProviderInterface
- That ContainerFactory must be updated (this is a critical integration point that's easy to forget!)
- The mocking pattern for `Symfony\Component\Process\Process`
- Previous story learnings or architectural decisions from 1.1-1.4

#### 2.4 Git History Analysis ✅

**Recent commits pattern analysis:**
- Task-focused commit messages: "Story X Task Y: ..."
- Each story gets dedicated commit batch
- Architecture files updated only in planning phase
- Implementation follows PSR-12 patterns consistently

#### 2.5 Latest Technical Research

**symfony/process (v7.4):**
- Latest stable version ^7.4 (in composer.json) ✅
- API: `Process::run()` is synchronous (can be long-running for LLM responses)
- Timeout handling: `Process::setTimeout($seconds)` before `run()`
- Exception: `ProcessFailedException` thrown when exit code != 0 ✅
- Cross-platform: Works on Windows/Linux/macOS
- **Best practice**: Always check `isSuccessful()` after `run()`
- **Warning**: Output can be large; LLM responses could exceed PHP memory if not truncated

**Ollama CLI:**
- Command format: `ollama run <model> <prompt>`
- Streaming: By default returns full response at once (not streaming)
- Timeout: No built-in timeout; process could hang
- Error codes: Non-zero exit if daemon unavailable or model not found
- **Best practice**: Verify model exists before first call (documented in onboarding wizard)

---

### Step 3: Disaster Prevention Gap Analysis

#### 3.1 Reinvention Prevention Gaps 🔴 **CRITICAL**

| Issue | Risk | Prevention |
|-------|------|-----------|
| **ProcessFactory pattern undefined** | Developer might create own factory (duplicate code) or skip factory entirely | **MUST:** Define whether ProcessFactory is needed; if yes, provide pattern from architecture (or similar abstraction) |
| **OllamaCliService location unclear** | Developer might create `src/Services/OllamaCliService` (wrong location) or `src/Llm/OllamaCliService` (right location but undocumented) | **MUST:** Explicitly state directory and explain pattern: domain-specific folders match interface domain |
| **Container registration forgotten** | Developer might implement OllamaCliService but forget to wire it in ContainerFactory, causing `ContainerNotFoundException` at runtime | **MUST:** Add explicit task "Update ContainerFactory with OllamaCliInterface binding" |

#### 3.2 Technical Specification DISASTERS 🔴 **CRITICAL**

| Requirement | Current State | Gap | Disaster Risk |
|-------------|--------------|-----|----------------|
| **A9: Use symfony/process** | Story mentions using it, but no code example | No example of Process instantiation, parameter passing, error handling | Developer might use wrong API or forget timeout configuration |
| **A4: Ollama CLI wrapper** | Story says "wraps symfony/process" but doesn't specify command structure | No clear translation: prompt string → `['ollama', 'run', 'mistral', $prompt]` | Developer might construct malformed command (injection risk?) |
| **A25: Log all prompts** | AC3 mentions "logs all prompts to audit trail" but format undefined | No specification: Should include model, timestamp, response length, exit code? | Audit trail might be unusable or incomplete for compliance |
| **NFR17: Graceful degradation** | AC4 mentions "graceful degradation" but implementation strategy missing | No exception handling pattern or fallback behavior documented | Developer might crash instead of degrading gracefully |
| **NFR6: Code snippet filtering** | AC5 mentions "only selected code snippets transmitted" but enforcement point unclear | No specification: Is truncation OllamaCliService responsibility or caller's? | Implementation might defeat intent (send unfiltered code) |

#### 3.3 File Structure DISASTERS 🟡 **SHOULD FIX**

| Issue | Current State | Fix Needed |
|-------|--------------|-----------|
| **Directory existence** | `src/Services/` doesn't exist; story references it implicitly | Add to story: Use `src/Llm/OllamaCliService.php` (directory exists) |
| **Interface-Implementation location** | Pattern established in Story 1.2: Interface in `src/Contracts/`, Implementation in domain folder | Confirm: `src/Contracts/OllamaCliInterface.php` → `src/Llm/OllamaCliService.php` |
| **Test location** | Pattern: Tests mirror src/ structure | Ensure: `tests/Llm/OllamaCliServiceTest.php` (directory must exist or be created) |

#### 3.4 Regression DISASTERS 🟡 **SHOULD FIX**

| Risk | Mitigation |
|------|-----------|
| **Breaking Service Container** | Story must document ContainerFactory update to avoid missing binding errors |
| **Skipping PSR-12 linting** | Story should remind: Run `vendor/bin/php-cs-fixer fix src/Llm/ --dry-run` to verify style |
| **Test coverage drop** | Story should mention: Existing Container tests won't break; new LLM tests must maintain ≥80% coverage (A30) |

#### 3.5 Implementation DISASTERS 🔴 **CRITICAL**

| Vagueness | Consequence | Clarity Needed |
|-----------|-----------|----------------|
| **"Generate with prompt and model selection" (AC2)** | Does OllamaCliService accept both as parameters? | **MUST:** Specify method signature: `public function generate(string $prompt, string $model = 'mistral'): string` |
| **"Pest tests mock symfony/process" (AC6)** | Developer unsure how to mock Process::run() | **MUST:** Provide test example showing Mockery::mock(Process::class) pattern |
| **"Graceful degradation if unreachable" (AC4)** | What should generate() return if Ollama down? | **MUST:** Specify: Throw exception + catch in caller? Or return empty string? Or log error + continue? |
| **"Only selected code snippets" (AC5)** | Enforcement point unclear | **MUST:** Clarify: Is this a hard constraint on OllamaCliService, or soft contract with caller? |

---

### Step 4: LLM-Dev-Agent Optimization Analysis

#### Clarity Issues for LLM Developer Agent

**Ambiguity Level: HIGH** 🔴

The story uses pattern references that assume developer context from earlier stories. An LLM developer agent reading this cold might make wrong decisions:

| Issue | How LLM Might Misinterpret |
|-------|--------------------------|
| "src/Services/OllamaCliService.php" mentioned in acceptance criteria | Creates `src/Services/` directory (wrong; should be `src/Llm/`) |
| "wraps symfony/process" without code example | Might wrap Process class incorrectly or use wrong method signatures |
| "logs all prompts to audit trail" without format spec | Might log minimal data (just prompt) instead of complete context |
| "mocks symfony/process successfully" without example | Might use incorrect Mockery syntax or mock wrong class |
| Task 1 says "Create OllamaCliInterface" but location not specified | Creates in `src/Services/Contracts/` (wrong; should be `src/Contracts/`) |

**Token Efficiency Issues:**
- Story mentions documents but doesn't include extracted architectural requirements inline
- Tests acceptance criteria but leaves implementation details to inference
- References "architecture" but doesn't quote key decisions
- Requires developer to consult multiple external files to understand design

#### Recommended Optimizations for LLM Processing

1. **Inline key architectural decisions** in Developer Context section
2. **Provide concrete code examples** (method signatures, test patterns)
3. **Define directory locations explicitly** (not "follow the pattern")
4. **Clarify vague requirements** (graceful degradation strategy, audit format)
5. **Include container registration as explicit task** (easy to forget)

---

### Step 5: Critical Improvements Identified

## 🚨 CRITICAL ISSUES (Must Fix Before Implementation)

### Issue 1: ProcessFactory Pattern Undefined 🔴

**Problem:** Architecture mentions ProcessFactory in container bindings, but story doesn't document this pattern.

**Current state:** 
- Story mentions "use symfony/process"
- Architecture shows `DI\get(ProcessFactory::class)` expected in OllamaProvider constructor
- ProcessFactory doesn't exist in codebase

**Decision required:** 
- **Option A**: Create ProcessFactory (for testability, timeout configuration)  
  ```php
  interface ProcessFactoryInterface {
      public function create(array $command, ?int $timeout = null): Process;
  }
  ```
- **Option B**: Instantiate Process directly in OllamaCliService (simpler, less abstraction)

**Recommendation:** Use **Option A** (factory pattern) for consistency with existing abstractions and testability.

**Action:** Add task to story: "Create src/Llm/ProcessFactory.php implementing ProcessFactoryInterface"

---

### Issue 2: OllamaCliService vs OllamaProvider Relationship Unclear 🔴

**Problem:** Story mentions both OllamaCliService (wraps symfony/process) and OllamaProviderInterface (exists as stub). Their relationship is undefined.

**Current state:**
- OllamaProviderInterface::explain() exists (from Story 1.2)
- OllamaProvider.php stub exists but unimplemented
- Story 1.5 requires OllamaCliService separate component

**Design decision required:**
- **Option A**: OllamaCliService is internal implementation detail; OllamaProvider public interface
  ```php
  class OllamaProvider implements OllamaProviderInterface {
      public function __construct(private OllamaCliService $cliService) {}
      public function explain(array $context): string {
          return $this->cliService->generate(json_encode($context));
      }
  }
  ```
- **Option B**: OllamaCliService is public interface; OllamaProvider delegates or doesn't exist
- **Option C**: Rename one to avoid confusion

**Recommendation:** Use **Option A** - OllamaCliService is internal implementation, OllamaProvider is the public face that Story 2.8 and 8.1 will use.

**Action:** Add to Developer Context: "OllamaCliService wraps symfony/process internally; public API is OllamaProviderInterface"

---

### Issue 3: Container Registration Missing as Task 🔴

**Problem:** Story doesn't mention updating ContainerFactory, causing easy-to-miss integration bug.

**Current state:**
- OllamaProviderInterface already bound in ContainerFactory
- But OllamaCliInterface (new in this story) needs binding too
- If developer forgets, `ContainerNotFoundException` occurs at runtime

**Example failure:**
```php
// This will fail if OllamaCliInterface not registered:
$service = $container->get(OllamaCliInterface::class); // throws NotFound
```

**Action:** Add explicit task: **Task 0.5: Register OllamaCliInterface in ContainerFactory**

---

### Issue 4: Audit Trail Logging Format Undefined 🟡

**Problem:** AC3 says "Logs all prompts to audit trail" but format is unspecified.

**Current state:**
- AuditTrailInterface::record() exists: `record(string $action, array $context): void`
- But example format not documented
- Story doesn't show what data to include

**Impact:** Developer might log insufficient data for compliance auditing.

**Recommended audit entry:**
```php
$auditTrail->record('ollama_prompt', [
    'prompt' => $prompt,
    'model' => $model,
    'timestamp' => date('c'),
    'request_id' => $requestId, // for tracing
    'code_snippet_length' => strlen($prompt), // for NFR6 verification
]);
```

**Action:** Add to Developer Context section: "Audit Trail Format Specification"

---

### Issue 5: Error Handling / Graceful Degradation Unspecified 🟡

**Problem:** AC4 requires "graceful degradation" but implementation strategy missing.

**Current state:**
- Story doesn't specify exception types to catch
- Story doesn't specify fallback behavior
- Approach: Crash? Log and continue? Return empty response?

**Architecture hint:** "Fall back to rule-based explanations (no LLM), continue migration"

**But current story:** Doesn't provide technical implementation detail.

**Recommended spec:**
```php
// AC4: Graceful degradation approach
try {
    $response = $this->generate($prompt, $model);
} catch (ProcessFailedException | LLMServiceUnavailableException $e) {
    // Degrade: return empty explanation, let caller decide next step
    $this->auditTrail->record('ollama_unavailable', ['error' => $e->getMessage()]);
    return '';
}
```

**Action:** Add to AC4: "Failed Ollama calls throw LLMServiceUnavailableException; caller decides fallback strategy"

---

### Issue 6: Code Snippet Filtering (NFR6) Enforcement Point Unclear 🟡

**Problem:** AC5 requires "Only selected code snippets transmitted" but enforcement unclear.

**Current state:**
- Is OllamaCliService responsible for truncating/filtering?
- Or is caller responsible for pre-filtering?
- Story doesn't specify

**Impact:** Developer might implement as "pass-through" (no filtering), defeating security requirement.

**Recommended spec:**
- **Caller responsibility**: User code decides what code to send: `$cliService->generate("relevant snippet here")`
- **OllamaCliService responsibility**: Enforce max length if needed: `if (strlen($prompt) > 50000) throw new PromptTooLongException()`

**Action:** Add to Developer Context: "NFR6 Enforcement Strategy: OllamaCliService enforces max prompt length (50KB), caller responsible for semantic filtering"

---

### Issue 7: Test Mocking Pattern for Process Not Documented 🟡

**Problem:** AC6 requires "Pest tests mock symfony/process" but pattern not shown.

**Current state:**
- No test example for mocking Process class
- Developer might not know correct Mockery syntax
- Pattern: `Mockery::mock(Process::class)`

**Recommended test example:**
```php
test('generate() returns ollama response', function () {
    $mockProcess = Mockery::mock(Process::class);
    $mockProcess->shouldReceive('run')->once();
    $mockProcess->shouldReceive('isSuccessful')->andReturn(true);
    $mockProcess->shouldReceive('getOutput')->andReturn('LLM response here');
    
    $mockFactory = Mockery::mock(ProcessFactoryInterface::class);
    $mockFactory->shouldReceive('create')->andReturn($mockProcess);
    
    $service = new OllamaCliService($mockFactory, $auditTrail);
    $result = $service->generate('prompt', 'mistral');
    
    expect($result)->toBe('LLM response here');
});
```

**Action:** Add to Developer Context: "Testing: Mocking Pattern for Process and ProcessFactory"

---

## 🟡 SHOULD-FIX ISSUES (Enhance Quality)

### Issue 8: Directory Location Not Explicitly Stated

**Current:** Story mentions "src/Services/OllamaCliService.php" but src/Services/ doesn't exist

**Fix:** Change to "src/Llm/OllamaCliService.php" (directory exists, matches domain pattern)

### Issue 9: Method Signature Not Specified

**Current:** AC2 says "Supports generate() method" but signature unclear

**Fix:** Add to story: `public function generate(string $prompt, string $model = 'mistral'): string`

### Issue 10: Edge Case Documentation Missing

**Current:** Story lists edge cases but lacks implementation strategy

**Fix:** Add pseudo-code or exception types:
- Windows: Path handling handled by symfony/process
- Process timeout: Configure via ProcessFactory (30 second default)
- Connection error: Throw LLMServiceUnavailableException

---

## 🟢 NICE-TO-HAVE IMPROVEMENTS

### Issue 11: Performance Hints

Add note: "Ollama response can be large (5KB-50KB). PHPStan monitors memory. Consider implementing response streaming if >NFR20 memory limit reached."

### Issue 12: Security Checklist

Add verification: "Story implementation maintains NFR5 (zero outbound calls)—all ollama execution is local."

### Issue 13: Integration Testing

Add optional task: "Create integration test that runs actual ollama with mistral model (if available in CI environment)"

---

## Summary of Recommendations

### Must Fix (Blocking Implementation)
1. ✅ Define ProcessFactory pattern (Option A recommended)
2. ✅ Clarify OllamaCliService vs OllamaProvider relationship
3. ✅ Add ContainerFactory update as explicit task
4. ✅ Specify audit trail logging format
5. ✅ Document error handling / graceful degradation strategy
6. ✅ Clarify NFR6 code snippet filtering enforcement point
7. ✅ Provide test mocking pattern example

### Should Fix (Quality Enhancement)
8. ✅ Correct directory path: `src/Llm/` not `src/Services/`
9. ✅ Specify method signature: `generate(string $prompt, string $model): string`
10. ✅ Expand edge case documentation with implementation hints

### Nice-to-Have (Optional)
11. ✅ Add performance hints for large responses
12. ✅ Add security verification checklist
13. ✅ Suggest integration testing approach

---

## Readiness Assessment

| Dimension | Score | Notes |
|-----------|-------|-------|
| **Requirements Clarity** | 70% | Core ACs clear, but technical details vague |
| **Architectural Context** | 60% | References architecture but doesn't inline decisions |
| **Previous Story Integration** | 50% | Doesn't mention Container or testing patterns from 1.2 |
| **Testing Guidance** | 40% | Requires mocking but no pattern example |
| **Error Handling Spec** | 30% | "Graceful degradation" undefined |
| **LLM Dev-Agent Optimization** | 50% | Ambiguous directory locations, vague requirements |

**Overall Readiness: 65/100 (Target: 80+)**

**Recommendation: IMPROVE BEFORE IMPLEMENTATION** 🔴

With the 7 critical issues and 3 should-fix issues resolved, story will be ready-for-dev with high confidence. Estimated effort to improve: 1-2 hours of documentation enhancement.

---

## Next Steps

1. **Update story file** with critical issue fixes (use improved story file as reference)
2. **Add Developer Context section** with architectural decisions and code examples
3. **Add inline container registration task** to prevent integration bugs
4. **Add test mocking examples** to minimize implementation uncertainty
5. **Clarify vague requirements** (graceful degradation, code snippet filtering, audit format)
6. **Re-validate against checklist** to confirm 80+ readiness

**Validated By:** BMad Story Validator (checklist.md)  
**Validation Date:** 2026-05-03  
**Status:** Ready for improvement planning
