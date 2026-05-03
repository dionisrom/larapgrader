---
story_key: "2-6-generate-time-estimates"
epic: "Epic 2: Pre-Migration Intelligence"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 2-6-generate-time-estimates: Generate time/effort estimates

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Generate time/effort estimates following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR7

---

## Acceptance Criteria

### AC 1: Estimates migration time based on code analysis (FR7)
- [ ] Estimates migration time based on code analysis (FR7)
### AC 2: Factors: lines of code, complexity, blast radius
- [ ] Factors: lines of code, complexity, blast radius
### AC 3: Outputs time estimate in hours/days
- [ ] Outputs time estimate in hours/days
### AC 4: Confidence-scored estimate ranges
- [ ] Confidence-scored estimate ranges
### AC 5: Includes effort breakdown by phase
- [ ] Includes effort breakdown by phase

---

## Tasks/Subtasks

### Task 1: Create src/Services/TimeEstimatorService.php
- [ ] Create src/Services/TimeEstimatorService.php
### Task 2: Calculate base effort from LOC and complexity
- [ ] Calculate base effort from LOC and complexity
### Task 3: Factor in blast radius and confidence scores
- [ ] Factor in blast radius and confidence scores
### Task 4: Generate time estimate with ranges
- [ ] Generate time estimate with ranges
### Task 5: Output effort breakdown (Phase A, Phase B)
- [ ] Output effort breakdown (Phase A, Phase B)
### Task 6: Write Pest tests with various codebases
- [ ] Write Pest tests with various codebases

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
