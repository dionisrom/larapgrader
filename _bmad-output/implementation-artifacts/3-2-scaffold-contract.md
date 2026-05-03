---
story_key: "3-2-scaffold-contract"
epic: "Epic 3: Migration Contract & Governance"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 3-2-scaffold-contract: Scaffold default Migration Contract

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Scaffold default Migration Contract following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR13

---

## Acceptance Criteria

### AC 1: Generates default Migration Contract YAML (FR13)
- [ ] Generates default Migration Contract YAML (FR13)
### AC 2: Includes default thresholds (auto-migrate ≥85, manual ≥60)
- [ ] Includes default thresholds (auto-migrate ≥85, manual ≥60)
### AC 3: Includes protected files/paths template
- [ ] Includes protected files/paths template
### AC 4: Includes approval gates configuration
- [ ] Includes approval gates configuration
### AC 5: Output is valid YAML parseable by 3.1
- [ ] Output is valid YAML parseable by 3.1

---

## Tasks/Subtasks

### Task 1: Create src/Services/ContractScaffolderService.php
- [ ] Create src/Services/ContractScaffolderService.php
### Task 2: Define default contract values
- [ ] Define default contract values
### Task 3: Generate YAML with symfony/yaml
- [ ] Generate YAML with symfony/yaml
### Task 4: Include all required sections (thresholds, paths, gates)
- [ ] Include all required sections (thresholds, paths, gates)
### Task 5: Write to file or stdout
- [ ] Write to file or stdout
### Task 6: Write Pest tests for scaffold output
- [ ] Write Pest tests for scaffold output

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
