---
story_key: "10-2-calculate-migration-order"
epic: "Epic 10: Domain-Aware Orchestration"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 10-2-calculate-migration-order: Calculate migration order based on dependencies

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Calculate migration order based on dependencies following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- Beta

---

## Acceptance Criteria

### AC 1: Calculates optimal migration order (Beta)
- [ ] Calculates optimal migration order (Beta)
### AC 2: Respects app dependencies from domain.json
- [ ] Respects app dependencies from domain.json
### AC 3: Topological sort of dependency graph
- [ ] Topological sort of dependency graph
### AC 4: Handles circular dependencies gracefully
- [ ] Handles circular dependencies gracefully
### AC 5: Outputs ordered migration plan
- [ ] Outputs ordered migration plan

---

## Tasks/Subtasks

### Task 1: Add order calculation to DomainLoader
- [ ] Add order calculation to DomainLoader
### Task 2: Build dependency graph from domain.json
- [ ] Build dependency graph from domain.json
### Task 3: Implement topological sort
- [ ] Implement topological sort
### Task 4: Detect and report circular dependencies
- [ ] Detect and report circular dependencies
### Task 5: Output ordered migration list
- [ ] Output ordered migration list
### Task 6: Write Pest tests with sample domains
- [ ] Write Pest tests with sample domains

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
