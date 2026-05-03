---
story_key: "10-4-generate-full-report"
epic: "Epic 10: Domain-Aware Orchestration"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 10-4-generate-full-report: Generate full aggregate report with sequencing (Beta)

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Generate full aggregate report with sequencing (Beta) following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- Beta

---

## Acceptance Criteria

### AC 1: Generates full aggregate report (Beta --domain)
- [ ] Generates full aggregate report (Beta --domain)
### AC 2: Includes migration order sequencing
- [ ] Includes migration order sequencing
### AC 3: Cross-app dependency visualization
- [ ] Cross-app dependency visualization
### AC 4: Detailed per-app breakdown
- [ ] Detailed per-app breakdown
### AC 5: Export to JSON/Markdown formats
- [ ] Export to JSON/Markdown formats

---

## Tasks/Subtasks

### Task 1: Create full aggregate report generator
- [ ] Create full aggregate report generator
### Task 2: Integrate migration order (10.2)
- [ ] Integrate migration order (10.2)
### Task 3: Add dependency visualization
- [ ] Add dependency visualization
### Task 4: Support multiple output formats
- [ ] Support multiple output formats
### Task 5: Include detailed statistics
- [ ] Include detailed statistics
### Task 6: Write Pest tests for full report
- [ ] Write Pest tests for full report

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
