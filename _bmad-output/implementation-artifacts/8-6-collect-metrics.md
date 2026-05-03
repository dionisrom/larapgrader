---
story_key: "8-6-collect-metrics"
epic: "Epic 8: Audit Trail & Compliance"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 8-6-collect-metrics: Collect success metrics for reporting

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Collect success metrics for reporting following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- A30
- FR28
- FR31

---

## Acceptance Criteria

### AC 1: Collects migration success metrics (A30)
- [ ] Collects migration success metrics (A30)
### AC 2: Records migration start/complete events (FR28)
- [ ] Records migration start/complete events (FR28)
### AC 3: Records rule applications with confidence (FR31)
- [ ] Records rule applications with confidence (FR31)
### AC 4: Records human interventions with rationale
- [ ] Records human interventions with rationale
### AC 5: Metrics stored for compliance report
- [ ] Metrics stored for compliance report

---

## Tasks/Subtasks

### Task 1: Create src/Services/MetricsCollector.php
- [ ] Create src/Services/MetricsCollector.php
### Task 2: Record migration events (start, complete)
- [ ] Record migration events (start, complete)
### Task 3: Track rule applications with scores
- [ ] Track rule applications with scores
### Task 4: Log human interventions
- [ ] Log human interventions
### Task 5: Store metrics in state registry (A5)
- [ ] Store metrics in state registry (A5)
### Task 6: Write Pest tests for metrics collection
- [ ] Write Pest tests for metrics collection

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
- Story file created from Epic 8: Audit Trail & Compliance
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
