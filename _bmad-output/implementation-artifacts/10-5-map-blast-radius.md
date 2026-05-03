---
story_key: "10-5-map-blast-radius"
epic: "Epic 10: Domain-Aware Orchestration"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 10-5-map-blast-radius: Map blast radius across app boundaries

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Map blast radius across app boundaries following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR6
- Beta

---

## Acceptance Criteria

### AC 1: Maps blast radius across app boundaries (FR6)
- [ ] Maps blast radius across app boundaries (FR6)
### AC 2: Cross-app dependency tracking
- [ ] Cross-app dependency tracking
### AC 3: Shared library impact analysis
- [ ] Shared library impact analysis
### AC 4: Domain-wide blast radius visualization
- [ ] Domain-wide blast radius visualization
### AC 5: Integrates with Epic 2 blast radius calculator
- [ ] Integrates with Epic 2 blast radius calculator

---

## Tasks/Subtasks

### Task 1: Extend blast radius calculator for cross-app
- [ ] Extend blast radius calculator for cross-app
### Task 2: Track shared dependencies across apps
- [ ] Track shared dependencies across apps
### Task 3: Calculate domain-wide impact
- [ ] Calculate domain-wide impact
### Task 4: Generate cross-app blast radius map
- [ ] Generate cross-app blast radius map
### Task 5: Visualize with dependency graph
- [ ] Visualize with dependency graph
### Task 6: Write Pest tests with multi-app domain
- [ ] Write Pest tests with multi-app domain

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
