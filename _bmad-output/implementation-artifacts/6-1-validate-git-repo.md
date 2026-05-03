---
story_key: "6-1-validate-git-repo"
epic: "Epic 6: Validation & Quality Gates"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 6-1-validate-git-repo: Validate git repository exists

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Validate git repository exists following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR32

---

## Acceptance Criteria

### AC 1: Validates git repository exists before transformation (FR32)
- [ ] Validates git repository exists before transformation (FR32)
### AC 2: Checks for .git directory
- [ ] Checks for .git directory
### AC 3: Verifies git commands are available
- [ ] Verifies git commands are available
### AC 4: Halts migration if not a git repo
- [ ] Halts migration if not a git repo
### AC 5: Logs validation result to audit trail
- [ ] Logs validation result to audit trail

---

## Tasks/Subtasks

### Task 1: Create src/Services/GitValidator.php
- [ ] Create src/Services/GitValidator.php
### Task 2: Check for .git directory existence
- [ ] Check for .git directory existence
### Task 3: Verify git binary is available
- [ ] Verify git binary is available
### Task 4: Return clear error if not a git repo
- [ ] Return clear error if not a git repo
### Task 5: Log validation to audit trail
- [ ] Log validation to audit trail
### Task 6: Write Pest tests with git/non-git directories
- [ ] Write Pest tests with git/non-git directories

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
