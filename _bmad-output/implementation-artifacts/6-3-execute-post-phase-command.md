---
story_key: "6-3-execute-post-phase-command"
epic: "Epic 6: Validation & Quality Gates"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 6-3-execute-post-phase-command: Execute post_phase_command and halt on failure

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Execute post_phase_command and halt on failure following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR28
- FR29
- FR30
- FR31

---

## Acceptance Criteria

### AC 1: Executes configured post_phase_command (FR28)
- [ ] Executes configured post_phase_command (FR28)
### AC 2: Halts migration if command fails (FR29)
- [ ] Halts migration if command fails (FR29)
### AC 3: Displays last modified file and diff on failure (FR30)
- [ ] Displays last modified file and diff on failure (FR30)
### AC 4: Logs execution to audit trail (FR31)
- [ ] Logs execution to audit trail (FR31)
### AC 5: Supports any shell command (NFR14)
- [ ] Supports any shell command (NFR14)

---

## Tasks/Subtasks

### Task 1: Create src/Services/PostPhaseCommandExecutor.php
- [ ] Create src/Services/PostPhaseCommandExecutor.php
### Task 2: Read command from Migration Contract or config
- [ ] Read command from Migration Contract or config
### Task 3: Execute via symfony/process (NFR14)
- [ ] Execute via symfony/process (NFR14)
### Task 4: Capture exit code and output
- [ ] Capture exit code and output
### Task 5: Halt on failure with file/diff context (FR30)
- [ ] Halt on failure with file/diff context (FR30)
### Task 6: Log execution to audit trail (FR31)
- [ ] Log execution to audit trail (FR31)
### Task 7: Write Pest tests with various commands
- [ ] Write Pest tests with various commands

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
**Completed Tasks:** 0/7
**Next Action:** Developer agent picks up story for implementation
