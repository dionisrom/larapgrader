---
story_key: "9-3-1-implement-knowledge"
epic: "Epic 9: CLI Interface & Developer Experience"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 9-3-1-implement-knowledge: Implement `knowledge` command

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Implement `knowledge` command following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR35
- FR36
- FR37
- FR38

---

## Acceptance Criteria

### AC 1: `knowledge show` - view knowledge base (FR38)
- [ ] `knowledge show` - view knowledge base (FR38)
### AC 2: Prompt to generalise resolved patterns (FR35)
- [ ] Prompt to generalise resolved patterns (FR35)
### AC 3: Confirm/reject generalisation (FR36)
- [ ] Confirm/reject generalisation (FR36)
### AC 4: Command structure with InputInterface/OutputInterface
- [ ] Command structure with InputInterface/OutputInterface

---

## Tasks/Subtasks

### Task 1: Create src/Commands/KnowledgeCommand.php
- [ ] Create src/Commands/KnowledgeCommand.php
### Task 2: Implement `knowledge show` subcommand (FR38)
- [ ] Implement `knowledge show` subcommand (FR38)
### Task 3: Add generalisation prompt flow (FR35)
- [ ] Add generalisation prompt flow (FR35)
### Task 4: Add confirm/reject flow (FR36)
- [ ] Add confirm/reject flow (FR36)
### Task 5: Use Symfony Console input/output (A2)
- [ ] Use Symfony Console input/output (A2)
### Task 6: Write Pest tests for knowledge command
- [ ] Write Pest tests for knowledge command

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
