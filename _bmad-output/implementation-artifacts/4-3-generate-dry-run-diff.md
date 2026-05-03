---
story_key: "4-3-generate-dry-run-diff"
epic: "Epic 4: Phase A - Lumen 8 → Laravel 8 Migration"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 4-3-generate-dry-run-diff: Generate dry-run diff with confidence scores

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Generate dry-run diff with confidence scores following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR10
- FR11
- FR12

---

## Acceptance Criteria

### AC 1: Generates dry-run diff (migrate plan) (FR10)
- [ ] Generates dry-run diff (migrate plan) (FR10)
### AC 2: Shows proposed changes file by file (FR11)
- [ ] Shows proposed changes file by file (FR11)
### AC 3: Includes confidence scores for each change (FR11)
- [ ] Includes confidence scores for each change (FR11)
### AC 4: Flags items below auto-migrate threshold (FR12)
- [ ] Flags items below auto-migrate threshold (FR12)
### AC 5: Output format: diff with confidence annotations
- [ ] Output format: diff with confidence annotations

---

## Tasks/Subtasks

### Task 1: Create src/Services/DryRunDiffGenerator.php
- [ ] Create src/Services/DryRunDiffGenerator.php
### Task 2: Run all rules in dry-run mode
- [ ] Run all rules in dry-run mode
### Task 3: Capture proposed changes with diff
- [ ] Capture proposed changes with diff
### Task 4: Annotate with confidence scores
- [ ] Annotate with confidence scores
### Task 5: Flag items needing manual review
- [ ] Flag items needing manual review
### Task 6: Write Pest tests with sample Lumen app
- [ ] Write Pest tests with sample Lumen app

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
