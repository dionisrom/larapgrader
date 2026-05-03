---
story_key: "3-4-implement-threshold-checking"
epic: "Epic 3: Migration Contract & Governance"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 3-4-implement-threshold-checking: Implement threshold checking

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Implement threshold checking following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR4
- FR14

---

## Acceptance Criteria

### AC 1: Classifies patterns: auto-migrate / review / incompatible (FR4)
- [ ] Classifies patterns: auto-migrate / review / incompatible (FR4)
### AC 2: Uses thresholds from Migration Contract (FR14)
- [ ] Uses thresholds from Migration Contract (FR14)
### AC 3: Auto-migrate: confidence ≥ 85
- [ ] Auto-migrate: confidence ≥ 85
### AC 4: Manual review: confidence 60-84
- [ ] Manual review: confidence 60-84
### AC 5: Incompatible: confidence < 60
- [ ] Incompatible: confidence < 60
### AC 6: Outputs classification with reasoning
- [ ] Outputs classification with reasoning

---

## Tasks/Subtasks

### Task 1: Create src/Services/ThresholdCheckerService.php
- [ ] Create src/Services/ThresholdCheckerService.php
### Task 2: Read thresholds from Migration Contract
- [ ] Read thresholds from Migration Contract
### Task 3: Classify based on confidence scores
- [ ] Classify based on confidence scores
### Task 4: Generate classification report
- [ ] Generate classification report
### Task 5: Integrate with confidence scorer
- [ ] Integrate with confidence scorer
### Task 6: Write Pest tests for all thresholds
- [ ] Write Pest tests for all thresholds

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
