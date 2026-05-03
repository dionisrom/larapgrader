---
story_key: "5-2-build-audit-layer"
epic: "Epic 5: Phase B - Laravel 8 → 13 Upgrade"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 5-2-build-audit-layer: Build custom audit layer for Rector changes

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Build custom audit layer for Rector changes following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR25
- NFR5

---

## Acceptance Criteria

### AC 1: Audit layer reviews Rector changes (FR25)
- [ ] Audit layer reviews Rector changes (FR25)
### AC 2: AST core makes zero outbound network calls (NFR5)
- [ ] AST core makes zero outbound network calls (NFR5)
### AC 3: Flags all changes for review
- [ ] Flags all changes for review
### AC 4: Compares before/after AST
- [ ] Compares before/after AST
### AC 5: Logs audit results to audit trail
- [ ] Logs audit results to audit trail

---

## Tasks/Subtasks

### Task 1: Create src/Services/RectorAuditLayer.php
- [ ] Create src/Services/RectorAuditLayer.php
### Task 2: Intercept Rector changes before apply
- [ ] Intercept Rector changes before apply
### Task 3: Compare AST before and after Rector
- [ ] Compare AST before and after Rector
### Task 4: Flag changes for manual review
- [ ] Flag changes for manual review
### Task 5: Ensure no network calls in audit (NFR5)
- [ ] Ensure no network calls in audit (NFR5)
### Task 6: Write Pest tests with sample Rector changes
- [ ] Write Pest tests with sample Rector changes

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
