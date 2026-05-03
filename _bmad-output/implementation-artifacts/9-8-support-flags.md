---
story_key: "9-8-support-flags"
epic: "Epic 9: CLI Interface & Developer Experience"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 9-8-support-flags: Support --no-ansi, --verbose, --quiet flags

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Support --no-ansi, --verbose, --quiet flags following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR45
- FR46
- NFR3

---

## Acceptance Criteria

### AC 1: Support --no-ansi flag for CI/logging (FR45)
- [ ] Support --no-ansi flag for CI/logging (FR45)
### AC 2: Support --verbose and --quiet flags (FR46)
- [ ] Support --verbose and --quiet flags (FR46)
### AC 3: Detect terminal capabilities
- [ ] Detect terminal capabilities
### AC 4: Stream progress for operations >60s (NFR3)
- [ ] Stream progress for operations >60s (NFR3)
### AC 5: Flags work across all commands
- [ ] Flags work across all commands

---

## Tasks/Subtasks

### Task 1: Add flag support to base command class
- [ ] Add flag support to base command class
### Task 2: Detect terminal capabilities for ANSI
- [ ] Detect terminal capabilities for ANSI
### Task 3: Implement --verbose output
- [ ] Implement --verbose output
### Task 4: Implement --quiet suppression
- [ ] Implement --quiet suppression
### Task 5: Add progress bar for long operations (NFR3)
- [ ] Add progress bar for long operations (NFR3)
### Task 6: Write Pest tests for flag combinations
- [ ] Write Pest tests for flag combinations

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
