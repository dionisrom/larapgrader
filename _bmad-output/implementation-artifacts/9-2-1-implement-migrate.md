---
story_key: "9-2-1-implement-migrate"
epic: "Epic 9: CLI Interface & Developer Experience"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 9-2-1-implement-migrate: Implement `migrate` command (plan + apply)

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Implement `migrate` command (plan + apply) following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR10
- FR11
- FR12
- FR17
- FR18
- FR21
- FR22
- FR23
- FR24
- FR25
- FR26
- FR27

---

## Acceptance Criteria

### AC 1: Implements `migrate plan` with dry-run diff (FR10-FR12)
- [ ] Implements `migrate plan` with dry-run diff (FR10-FR12)
### AC 2: Implements `migrate apply` with snapshot (FR17-FR18)
- [ ] Implements `migrate apply` with snapshot (FR17-FR18)
### AC 3: Handles Phase A → Phase B gate checking (FR22-FR23)
- [ ] Handles Phase A → Phase B gate checking (FR22-FR23)
### AC 4: Integrates rollback and state registry
- [ ] Integrates rollback and state registry
### AC 5: Command structure with InputInterface/OutputInterface
- [ ] Command structure with InputInterface/OutputInterface

---

## Tasks/Subtasks

### Task 1: Create src/Commands/MigrateCommand.php
- [ ] Create src/Commands/MigrateCommand.php
### Task 2: Implement `migrate plan` subcommand
- [ ] Implement `migrate plan` subcommand
### Task 3: Implement `migrate apply` subcommand
- [ ] Implement `migrate apply` subcommand
### Task 4: Integrate Phase A and Phase B executors
- [ ] Integrate Phase A and Phase B executors
### Task 5: Add gate checking (Phase A before B)
- [ ] Add gate checking (Phase A before B)
### Task 6: Write Pest tests for migrate command
- [ ] Write Pest tests for migrate command

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
