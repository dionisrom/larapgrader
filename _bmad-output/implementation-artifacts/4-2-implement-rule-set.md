---
story_key: "4-2-implement-rule-set"
epic: "Epic 4: Phase A - Lumen 8 → Laravel 8 Migration"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 4-2-implement-rule-set: Implement Lumen 8 → Laravel 8 rule set

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Implement Lumen 8 → Laravel 8 rule set following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR24

---

## Acceptance Criteria

### AC 1: Bootstrap.php transformation (Lumen → Laravel) (4.2.1)
- [ ] Bootstrap.php transformation (Lumen → Laravel) (4.2.1)
### AC 2: Middleware registration transformation (4.2.2)
- [ ] Middleware registration transformation (4.2.2)
### AC 3: Routing conversion (Lumen → Laravel Route::) (4.2.3)
- [ ] Routing conversion (Lumen → Laravel Route::) (4.2.3)
### AC 4: Config file extraction (Lumen configure() → Laravel config/) (4.2.4)
- [ ] Config file extraction (Lumen configure() → Laravel config/) (4.2.4)
### AC 5: Eloquent factories handling (4.2.5)
- [ ] Eloquent factories handling (4.2.5)
### AC 6: All 5 rule types implemented and tested
- [ ] All 5 rule types implemented and tested

---

## Tasks/Subtasks

### Task 1: Create rule classes for each transformation type
- [ ] Create rule classes for each transformation type
### Task 2: Implement BootstrapTransformer rule
- [ ] Implement BootstrapTransformer rule
### Task 3: Implement MiddlewareTransformer rule
- [ ] Implement MiddlewareTransformer rule
### Task 4: Implement RoutingTransformer rule
- [ ] Implement RoutingTransformer rule
### Task 5: Implement ConfigExtractor rule
- [ ] Implement ConfigExtractor rule
### Task 6: Implement EloquentFactoryTransformer rule
- [ ] Implement EloquentFactoryTransformer rule
### Task 7: Write Pest tests for each rule
- [ ] Write Pest tests for each rule

---

## Dev Agent Record (Debug Log)

### Implementation Plan
1. Review requirements mapping and acceptance criteria
2. Implement core functionality following PSR-12 coding standard (A19)
3. Use constructor injection for all dependencies (A20)
4. Write comprehensive Pest tests (A27, A28)
5. Ensure all tests pass 100% (A26)
6. Run PHPStan --level=8 for static analysis (A29)

### Technical Decisions
- Follow PSR-12 coding standard (A19)
- Use constructor injection (not `new` in methods) (A20)
- Return named constants for exit codes (A23)
- Log all LLM prompts to audit trail (A25)
- Use Symfony Console output methods (A22)

### Edge Cases
- Windows: Ensure path handling works with backslashes
- macOS/Linux: Verify symfony/process works correctly
- Error handling: Graceful degradation if dependencies unavailable
- Testing: Mock all external dependencies in Pest tests (A28)

---

## File List

### Created Files (to be filled during implementation)
- To be determined based on implementation

### Modified Files
- To be determined based on implementation

---

## Change Log

### 2026-05-03: Story Created
- Story file created from Epic 4: Phase A - Lumen 8 → Laravel 8 Migration
- All requirements mapped from Architecture and PRD documents
- Acceptance Criteria defined with checkboxes
- Tasks broken down into actionable items
- Dev Agent Record includes implementation plan and edge cases

---

## Status

**Current Status:** ready-for-dev
**Last Updated:** 2026-05-03
**Completed Tasks:** 0/7
**Next Action:** Developer agent picks up story for implementation
