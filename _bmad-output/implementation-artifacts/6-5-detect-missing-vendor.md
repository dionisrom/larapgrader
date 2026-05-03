---
story_key: "6-5-detect-missing-vendor"
epic: "Epic 6: Validation & Quality Gates"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 6-5-detect-missing-vendor: Detect and warn about missing/stale vendor/

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Detect and warn about missing/stale vendor/ following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR49

---

## Acceptance Criteria

### AC 1: Detects missing vendor/ directory (FR49)
- [ ] Detects missing vendor/ directory (FR49)
### AC 2: Warns when vendor/ is stale (old composer.lock)
- [ ] Warns when vendor/ is stale (old composer.lock)
### AC 3: Suggests running `composer install`
- [ ] Suggests running `composer install`
### AC 4: Continues with warning (not hard halt)
- [ ] Continues with warning (not hard halt)
### AC 5: Logs warning to audit trail
- [ ] Logs warning to audit trail

---

## Tasks/Subtasks

### Task 1: Add vendor detection to validation
- [ ] Add vendor detection to validation
### Task 2: Check vendor/ directory exists
- [ ] Check vendor/ directory exists
### Task 3: Compare composer.lock timestamp to vendor/
- [ ] Compare composer.lock timestamp to vendor/
### Task 4: Warn if vendor/ is missing or stale
- [ ] Warn if vendor/ is missing or stale
### Task 5: Log warning to audit trail
- [ ] Log warning to audit trail
### Task 6: Write Pest tests for missing/stale vendor
- [ ] Write Pest tests for missing/stale vendor

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
- Story file created from Epic 6: Validation & Quality Gates
- All requirements mapped from Architecture and PRD documents
- Acceptance Criteria defined with checkboxes
- Tasks broken down into actionable items
- Dev Agent Record includes implementation plan and edge cases

---

## Status

**Current Status:** ready-for-dev
**Last Updated:** 2026-05-03
**Completed Tasks:** 0/6
**Next Action:** Developer agent picks up story for implementation
