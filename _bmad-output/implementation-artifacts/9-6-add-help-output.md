---
story_key: "9-6-add-help-output"
epic: "Epic 9: CLI Interface & Developer Experience"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 9-6-add-help-output: Add comprehensive --help output

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Add comprehensive --help output following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR43

---

## Acceptance Criteria

### AC 1: Comprehensive --help output (FR43)
- [ ] Comprehensive --help output (FR43)
### AC 2: Includes description, flags, examples, exit codes
- [ ] Includes description, flags, examples, exit codes
### AC 3: All commands have --help
- [ ] All commands have --help
### AC 4: Examples of common invocations
- [ ] Examples of common invocations
### AC 5: Exit codes documented (0, 1, 2, 3)
- [ ] Exit codes documented (0, 1, 2, 3)

---

## Tasks/Subtasks

### Task 1: Add help text to all CLI commands
- [ ] Add help text to all CLI commands
### Task 2: Include description and usage examples
- [ ] Include description and usage examples
### Task 3: Document all flags and options
- [ ] Document all flags and options
### Task 4: Add exit codes documentation
- [ ] Add exit codes documentation
### Task 5: Test --help output for each command
- [ ] Test --help output for each command
### Task 6: Write Pest tests for help output
- [ ] Write Pest tests for help output

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
