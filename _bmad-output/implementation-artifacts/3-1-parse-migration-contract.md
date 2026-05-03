---
story_key: "3-1-parse-migration-contract"
epic: "Epic 3: Migration Contract & Governance"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 3-1-parse-migration-contract: Parse Migration Contract YAML

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Parse Migration Contract YAML following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR14
- A10

---

## Acceptance Criteria

### AC 1: Parses Migration Contract YAML file (FR14)
- [ ] Parses Migration Contract YAML file (FR14)
### AC 2: Uses symfony/yaml for parsing (A10)
- [ ] Uses symfony/yaml for parsing (A10)
### AC 3: Validates YAML structure
- [ ] Validates YAML structure
### AC 4: Returns structured contract object
- [ ] Returns structured contract object
### AC 5: Handles missing or malformed YAML gracefully
- [ ] Handles missing or malformed YAML gracefully

---

## Tasks/Subtasks

### Task 1: Create src/Contracts/ContractParserInterface.php (if not exists)
- [ ] Create src/Contracts/ContractParserInterface.php (if not exists)
### Task 2: Implement src/Services/ContractParserService.php
- [ ] Implement src/Services/ContractParserService.php
### Task 3: Use symfony/yaml to parse YAML (A10)
- [ ] Use symfony/yaml to parse YAML (A10)
### Task 4: Define contract schema (thresholds, protected paths)
- [ ] Define contract schema (thresholds, protected paths)
### Task 5: Add error handling for malformed YAML
- [ ] Add error handling for malformed YAML
### Task 6: Write Pest tests with sample YAML files
- [ ] Write Pest tests with sample YAML files

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
