---
story_key: "9-5-1-implement-contract"
epic: "Epic 9: CLI Interface & Developer Experience"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 9-5-1-implement-contract: Implement `contract` command

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Implement `contract` command following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR13
- FR14
- FR15
- FR16

---

## Acceptance Criteria

### AC 1: `contract init` - scaffold Migration Contract (FR13)
- [ ] `contract init` - scaffold Migration Contract (FR13)
### AC 2: Validate contract before apply (FR16)
- [ ] Validate contract before apply (FR16)
### AC 3: Check thresholds and protected paths (FR14)
- [ ] Check thresholds and protected paths (FR14)
### AC 4: Contract is versionable YAML in repo (FR15)
- [ ] Contract is versionable YAML in repo (FR15)
### AC 5: Command structure with InputInterface/OutputInterface
- [ ] Command structure with InputInterface/OutputInterface

---

## Tasks/Subtasks

### Task 1: Create src/Commands/ContractCommand.php
- [ ] Create src/Commands/ContractCommand.php
### Task 2: Implement `contract init` subcommand (FR13)
- [ ] Implement `contract init` subcommand (FR13)
### Task 3: Add contract validation (FR16)
- [ ] Add contract validation (FR16)
### Task 4: Check thresholds and paths (FR14)
- [ ] Check thresholds and paths (FR14)
### Task 5: Use Symfony Console input/output (A2)
- [ ] Use Symfony Console input/output (A2)
### Task 6: Write Pest tests for contract command
- [ ] Write Pest tests for contract command

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
