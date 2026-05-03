---
story_key: "2-4-build-blast-radius-calculator"
epic: "Epic 2: Pre-Migration Intelligence"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 2-4-build-blast-radius-calculator: Build blast radius calculator

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Build blast radius calculator following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR6

---

## Acceptance Criteria

### AC 1: Calculates cascading impact of changes (FR6)
- [ ] Calculates cascading impact of changes (FR6)
### AC 2: Maps file dependencies via symbol index
- [ ] Maps file dependencies via symbol index
### AC 3: Outputs blast radius map with affected files
- [ ] Outputs blast radius map with affected files
### AC 4: Highlights high-risk cascading chains
- [ ] Highlights high-risk cascading chains
### AC 5: Integrates with confidence scorer
- [ ] Integrates with confidence scorer

---

## Tasks/Subtasks

### Task 1: Create src/Contracts/BlastRadiusCalculatorInterface.php (if not exists)
- [ ] Create src/Contracts/BlastRadiusCalculatorInterface.php (if not exists)
### Task 2: Implement src/Services/BlastRadiusCalculatorService.php
- [ ] Implement src/Services/BlastRadiusCalculatorService.php
### Task 3: Traverse dependency graph from symbol index
- [ ] Traverse dependency graph from symbol index
### Task 4: Calculate impact score for each file
- [ ] Calculate impact score for each file
### Task 5: Generate blast radius map output
- [ ] Generate blast radius map output
### Task 6: Write Pest tests with sample dependency graph
- [ ] Write Pest tests with sample dependency graph

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
- Story file created from Epic 2: Pre-Migration Intelligence
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
