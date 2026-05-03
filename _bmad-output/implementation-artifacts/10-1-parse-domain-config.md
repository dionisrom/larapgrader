---
story_key: "10-1-parse-domain-config"
epic: "Epic 10: Domain-Aware Orchestration"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 10-1-parse-domain-config: Parse domain.json configuration

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Parse domain.json configuration following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- A18

---

## Acceptance Criteria

### AC 1: Parses domain.json configuration (A18)
- [ ] Parses domain.json configuration (A18)
### AC 2: DomainLoader in src/Domain/DomainLoader.php (A18)
- [ ] DomainLoader in src/Domain/DomainLoader.php (A18)
### AC 3: Extracts app list and dependencies
- [ ] Extracts app list and dependencies
### AC 4: Validates domain.json schema
- [ ] Validates domain.json schema
### AC 5: Returns structured domain object
- [ ] Returns structured domain object

---

## Tasks/Subtasks

### Task 1: Create src/Domain/DomainLoader.php (A18)
- [ ] Create src/Domain/DomainLoader.php (A18)
### Task 2: Define domain.json schema
- [ ] Define domain.json schema
### Task 3: Parse JSON with validation
- [ ] Parse JSON with validation
### Task 4: Extract app entries and dependencies
- [ ] Extract app entries and dependencies
### Task 5: Handle missing or invalid domain.json
- [ ] Handle missing or invalid domain.json
### Task 6: Write Pest tests for domain parsing
- [ ] Write Pest tests for domain parsing

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
- Story file created from Epic 10: Domain-Aware Orchestration
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
