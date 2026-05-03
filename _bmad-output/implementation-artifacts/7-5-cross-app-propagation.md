---
story_key: "7-5-cross-app-propagation"
epic: "Epic 7: Knowledge Capture & Pattern Resolution"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 7-5-cross-app-propagation: Cross-app knowledge propagation (Beta)

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Cross-app knowledge propagation (Beta) following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- Beta

---

## Acceptance Criteria

### AC 1: Propagates patterns across apps (Beta)
- [ ] Propagates patterns across apps (Beta)
### AC 2: Suggests patterns from other apps
- [ ] Suggests patterns from other apps
### AC 3: Matches by code similarity
- [ ] Matches by code similarity
### AC 4: Beta feature - may have limitations
- [ ] Beta feature - may have limitations
### AC 5: Integrates with domain orchestration (Epic 10)
- [ ] Integrates with domain orchestration (Epic 10)

---

## Tasks/Subtasks

### Task 1: Add cross-app pattern matching
- [ ] Add cross-app pattern matching
### Task 2: Query knowledge bases from other apps
- [ ] Query knowledge bases from other apps
### Task 3: Calculate code similarity scores
- [ ] Calculate code similarity scores
### Task 4: Suggest applicable patterns
- [ ] Suggest applicable patterns
### Task 5: Beta label in documentation
- [ ] Beta label in documentation
### Task 6: Write Pest tests for propagation
- [ ] Write Pest tests for propagation

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
- Story file created from Epic 7: Knowledge Capture & Pattern Resolution
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
