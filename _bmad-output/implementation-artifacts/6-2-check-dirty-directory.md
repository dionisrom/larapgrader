---
story_key: "6-2-check-dirty-directory"
epic: "Epic 6: Validation & Quality Gates"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 6-2-check-dirty-directory: Check for dirty working directory

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Check for dirty working directory following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR33

---

## Acceptance Criteria

### AC 1: Checks for dirty working directory (FR33)
- [ ] Checks for dirty working directory (FR33)
### AC 2: Runs `git status --porcelain`
- [ ] Runs `git status --porcelain`
### AC 3: Halts if uncommitted changes exist
- [ ] Halts if uncommitted changes exist
### AC 4: Suggests `git stash` or commit
- [ ] Suggests `git stash` or commit
### AC 5: Logs check result to audit trail
- [ ] Logs check result to audit trail

---

## Tasks/Subtasks

### Task 1: Add dirty check to GitValidator
- [ ] Add dirty check to GitValidator
### Task 2: Run git status to detect uncommitted changes
- [ ] Run git status to detect uncommitted changes
### Task 3: Parse git output for dirty state
- [ ] Parse git output for dirty state
### Task 4: Halt migration with clear message
- [ ] Halt migration with clear message
### Task 5: Log check result to audit trail
- [ ] Log check result to audit trail
### Task 6: Write Pest tests with clean/dirty repos
- [ ] Write Pest tests with clean/dirty repos

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
