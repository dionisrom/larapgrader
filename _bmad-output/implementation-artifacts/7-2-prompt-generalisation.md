---
story_key: "7-2-prompt-generalisation"
epic: "Epic 7: Knowledge Capture & Pattern Resolution"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 7-2-prompt-generalisation: Prompt to generalise resolved patterns

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Prompt to generalise resolved patterns following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR35

---

## Acceptance Criteria

### AC 1: Prompts to generalise resolved patterns (FR35)
- [ ] Prompts to generalise resolved patterns (FR35)
### AC 2: Appears after human resolution
- [ ] Appears after human resolution
### AC 3: Uses LLM to suggest generalisation (A4)
- [ ] Uses LLM to suggest generalisation (A4)
### AC 4: Shows preview of generalised pattern
- [ ] Shows preview of generalised pattern
### AC 5: Logs prompt to audit trail (A25)
- [ ] Logs prompt to audit trail (A25)

---

## Tasks/Subtasks

### Task 1: Add generalisation prompt after resolution
- [ ] Add generalisation prompt after resolution
### Task 2: Use Ollama CLI for LLM suggestions (A4)
- [ ] Use Ollama CLI for LLM suggestions (A4)
### Task 3: Display preview to user
- [ ] Display preview to user
### Task 4: Log prompt to audit trail (A25)
- [ ] Log prompt to audit trail (A25)
### Task 5: Store generalised pattern on accept
- [ ] Store generalised pattern on accept
### Task 6: Write Pest tests with mocked Ollama
- [ ] Write Pest tests with mocked Ollama

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
