---
story_key: "3-6-enforce-contract-violations"
epic: "Epic 3: Migration Contract & Governance"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 3-6-enforce-contract-violations: Enforce contract violations and halt migration

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Enforce contract violations and halt migration following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR27

---

## Acceptance Criteria

### AC 1: Detects mid-migration contract violations (FR27)
- [ ] Detects mid-migration contract violations (FR27)
### AC 2: Halts migration immediately
- [ ] Halts migration immediately
### AC 3: Logs violation details to audit trail
- [ ] Logs violation details to audit trail
### AC 4: Preserves partial progress for resume
- [ ] Preserves partial progress for resume
### AC 5: Returns appropriate exit code (3 for human review)
- [ ] Returns appropriate exit code (3 for human review)

---

## Tasks/Subtasks

### Task 1: Add violation detection to migration execution
- [ ] Add violation detection to migration execution
### Task 2: Halt on contract violation
- [ ] Halt on contract violation
### Task 3: Log violation with context to audit trail
- [ ] Log violation with context to audit trail
### Task 4: Ensure state registry preserves progress
- [ ] Ensure state registry preserves progress
### Task 5: Return exit code 3 (human review needed)
- [ ] Return exit code 3 (human review needed)
### Task 6: Write Pest tests for violation scenarios
- [ ] Write Pest tests for violation scenarios

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
- Story file created from Epic 3: Migration Contract & Governance
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
