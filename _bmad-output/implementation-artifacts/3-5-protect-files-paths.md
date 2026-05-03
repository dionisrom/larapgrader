---
story_key: "3-5-protect-files-paths"
epic: "Epic 3: Migration Contract & Governance"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 3-5-protect-files-paths: Protect files/paths from automatic transformation

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Protect files/paths from automatic transformation following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR14

---

## Acceptance Criteria

### AC 1: Reads protected paths from Migration Contract (FR14)
- [ ] Reads protected paths from Migration Contract (FR14)
### AC 2: Prevents automatic transformation of protected files
- [ ] Prevents automatic transformation of protected files
### AC 3: Supports glob patterns (*.env, config/*.php)
- [ ] Supports glob patterns (*.env, config/*.php)
### AC 4: Logs protection violations to audit trail
- [ ] Logs protection violations to audit trail
### AC 5: Halts migration if protected file would be modified
- [ ] Halts migration if protected file would be modified

---

## Tasks/Subtasks

### Task 1: Create src/Services/FileProtectionService.php
- [ ] Create src/Services/FileProtectionService.php
### Task 2: Parse protected_paths from contract
- [ ] Parse protected_paths from contract
### Task 3: Match file paths against protected patterns
- [ ] Match file paths against protected patterns
### Task 4: Block transformations on protected files
- [ ] Block transformations on protected files
### Task 5: Log violations to audit trail
- [ ] Log violations to audit trail
### Task 6: Write Pest tests with various glob patterns
- [ ] Write Pest tests with various glob patterns

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
