---
story_key: "9-7-implement-exit-codes"
epic: "Epic 9: CLI Interface & Developer Experience"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 9-7-implement-exit-codes: Implement exit codes

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Implement exit codes following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR44

---

## Acceptance Criteria

### AC 1: Meaningful exit codes (FR44)
- [ ] Meaningful exit codes (FR44)
### AC 2: 0=success, 1=confidence gate, 2=error, 3=human review
- [ ] 0=success, 1=confidence gate, 2=error, 3=human review
### AC 3: Return named constants (not magic numbers) (A23)
- [ ] Return named constants (not magic numbers) (A23)
### AC 4: Map exit codes to meaningful messages
- [ ] Map exit codes to meaningful messages
### AC 5: All commands return proper exit codes
- [ ] All commands return proper exit codes

---

## Tasks/Subtasks

### Task 1: Define exit code constants (A23)
- [ ] Define exit code constants (A23)
### Task 2: Update all commands to return named constants
- [ ] Update all commands to return named constants
### Task 3: Map exit codes to messages
- [ ] Map exit codes to messages
### Task 4: Test each exit code scenario
- [ ] Test each exit code scenario
### Task 5: Document exit codes in --help
- [ ] Document exit codes in --help
### Task 6: Write Pest tests for exit codes
- [ ] Write Pest tests for exit codes

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
- Story file created from Epic 9: CLI Interface & Developer Experience
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
