---
story_key: "5-3-detect-custom-code"
epic: "Epic 5: Phase B - Laravel 8 → 13 Upgrade"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 5-3-detect-custom-code: Detect custom code proximity to Rector transformations

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Detect custom code proximity to Rector transformations following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR25

---

## Acceptance Criteria

### AC 1: Detects custom code near Rector changes (FR25)
- [ ] Detects custom code near Rector changes (FR25)
### AC 2: Uses symbol index for proximity analysis
- [ ] Uses symbol index for proximity analysis
### AC 3: Flags high-risk proximity areas
- [ ] Flags high-risk proximity areas
### AC 4: Suggests manual review for custom code
- [ ] Suggests manual review for custom code
### AC 5: Integrates with audit layer
- [ ] Integrates with audit layer

---

## Tasks/Subtasks

### Task 1: Enhance RectorAuditLayer with proximity detection
- [ ] Enhance RectorAuditLayer with proximity detection
### Task 2: Use SymbolIndex for dependency analysis
- [ ] Use SymbolIndex for dependency analysis
### Task 3: Calculate proximity scores
- [ ] Calculate proximity scores
### Task 4: Flag files needing manual review
- [ ] Flag files needing manual review
### Task 5: Generate proximity report
- [ ] Generate proximity report
### Task 6: Write Pest tests with custom code samples
- [ ] Write Pest tests with custom code samples

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
- Story file created from Epic 5: Phase B - Laravel 8 → 13 Upgrade
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
