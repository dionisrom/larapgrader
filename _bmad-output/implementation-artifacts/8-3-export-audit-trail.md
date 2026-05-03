---
story_key: "8-3-export-audit-trail"
epic: "Epic 8: Audit Trail & Compliance"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 8-3-export-audit-trail: Export full audit trail for compliance

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Export full audit trail for compliance following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR41

---

## Acceptance Criteria

### AC 1: Exports full audit trail (FR41)
- [ ] Exports full audit trail (FR41)
### AC 2: Output format: JSONL (FR41)
- [ ] Output format: JSONL (FR41)
### AC 3: Supports date range filtering
- [ ] Supports date range filtering
### AC 4: Includes all transformation records
- [ ] Includes all transformation records
### AC 5: Ready for compliance sign-off
- [ ] Ready for compliance sign-off

---

## Tasks/Subtasks

### Task 1: Create `report export` CLI command
- [ ] Create `report export` CLI command
### Task 2: Read audit trail JSONL file
- [ ] Read audit trail JSONL file
### Task 3: Support date range filtering
- [ ] Support date range filtering
### Task 4: Output formatted audit trail
- [ ] Output formatted audit trail
### Task 5: Include summary statistics
- [ ] Include summary statistics
### Task 6: Write Pest tests for export command
- [ ] Write Pest tests for export command

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
