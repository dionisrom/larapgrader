---
story_key: "4-7-run-smoke-test"
epic: "Epic 4: Phase A - Lumen 8 → Laravel 8 Migration"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 4-7-run-smoke-test: Run smoke test after Phase A

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Run smoke test after Phase A following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR34

---

## Acceptance Criteria

### AC 1: Runs smoke test after Phase A (FR34)
- [ ] Runs smoke test after Phase A (FR34)
### AC 2: Executes `php artisan --version`
- [ ] Executes `php artisan --version`
### AC 3: Verifies Laravel 8 installed correctly
- [ ] Verifies Laravel 8 installed correctly
### AC 4: Halts migration if smoke test fails
- [ ] Halts migration if smoke test fails
### AC 5: Logs smoke test results to audit trail
- [ ] Logs smoke test results to audit trail

---

## Tasks/Subtasks

### Task 1: Create src/Services/SmokeTesterService.php
- [ ] Create src/Services/SmokeTesterService.php
### Task 2: Run `php artisan --version` after Phase A
- [ ] Run `php artisan --version` after Phase A
### Task 3: Parse output to verify Laravel version
- [ ] Parse output to verify Laravel version
### Task 4: Handle test failure gracefully
- [ ] Handle test failure gracefully
### Task 5: Log results to audit trail
- [ ] Log results to audit trail
### Task 6: Write Pest tests with mocked process
- [ ] Write Pest tests with mocked process

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
**Completed Tasks:** 0/6
**Next Action:** Developer agent picks up story for implementation
