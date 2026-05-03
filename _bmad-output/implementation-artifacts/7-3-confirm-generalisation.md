---
story_key: "7-3-confirm-generalisation"
epic: "Epic 7: Knowledge Capture & Pattern Resolution"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 7-3-confirm-generalisation: Confirm/reject generalisation before applying

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Confirm/reject generalisation before applying following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR36

---

## Acceptance Criteria

### AC 1: Confirms/rejects generalisation before applying (FR36)
- [ ] Confirms/rejects generalisation before applying (FR36)
### AC 2: Shows diff between original and generalised
- [ ] Shows diff between original and generalised
### AC 3: User can accept, reject, or modify
- [ ] User can accept, reject, or modify
### AC 4: Only applies if confirmed
- [ ] Only applies if confirmed
### AC 5: Logs confirmation decision to audit trail
- [ ] Logs confirmation decision to audit trail

---

## Tasks/Subtasks

### Task 1: Add confirmation step to generalisation flow
- [ ] Add confirmation step to generalisation flow
### Task 2: Display diff of generalisation
- [ ] Display diff of generalisation
### Task 3: Prompt user for confirmation
- [ ] Prompt user for confirmation
### Task 4: Apply or reject based on input
- [ ] Apply or reject based on input
### Task 5: Log decision to audit trail
- [ ] Log decision to audit trail
### Task 6: Write Pest tests for confirm/reject
- [ ] Write Pest tests for confirm/reject

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
