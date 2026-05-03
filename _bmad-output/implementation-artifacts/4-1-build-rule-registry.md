---
story_key: "4-1-build-rule-registry"
epic: "Epic 4: Phase A - Lumen 8 → Laravel 8 Migration"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 4-1-build-rule-registry: Build composable rule registry

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Build composable rule registry following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR24
- A13

---

## Acceptance Criteria

### AC 1: Rule registry stores transformation rules (FR24)
- [ ] Rule registry stores transformation rules (FR24)
### AC 2: Rules are composable and reusable (FR24)
- [ ] Rules are composable and reusable (FR24)
### AC 3: Supports rule priority/ordering
- [ ] Supports rule priority/ordering
### AC 4: Interface defined in src/Contracts/ (A13)
- [ ] Interface defined in src/Contracts/ (A13)
### AC 5: Registry is injectable via container (A6, A20)
- [ ] Registry is injectable via container (A6, A20)

---

## Tasks/Subtasks

### Task 1: Create src/Contracts/RuleRegistryInterface.php (if not exists)
- [ ] Create src/Contracts/RuleRegistryInterface.php (if not exists)
### Task 2: Implement src/Services/RuleRegistryService.php
- [ ] Implement src/Services/RuleRegistryService.php
### Task 3: Define RuleInterface for individual rules
- [ ] Define RuleInterface for individual rules
### Task 4: Support adding/removing rules dynamically
- [ ] Support adding/removing rules dynamically
### Task 5: Implement rule execution pipeline
- [ ] Implement rule execution pipeline
### Task 6: Write Pest tests for registry and rules
- [ ] Write Pest tests for registry and rules

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
- Story file created from Epic 4: Phase A - Lumen 8 → Laravel 8 Migration
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
