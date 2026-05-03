---
story_key: "7-4-view-knowledge-base"
epic: "Epic 7: Knowledge Capture & Pattern Resolution"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 7-4-view-knowledge-base: View accumulated knowledge base

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

View accumulated knowledge base following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR38

---

## Acceptance Criteria

### AC 1: Views accumulated knowledge base (FR38)
- [ ] Views accumulated knowledge base (FR38)
### AC 2: CLI command: `knowledge show`
- [ ] CLI command: `knowledge show`
### AC 3: Displays patterns by type/category
- [ ] Displays patterns by type/category
### AC 4: Shows pattern details and usage count
- [ ] Shows pattern details and usage count
### AC 5: Supports filtering and search
- [ ] Supports filtering and search

---

## Tasks/Subtasks

### Task 1: Create `knowledge show` CLI command
- [ ] Create `knowledge show` CLI command
### Task 2: Format knowledge base output
- [ ] Format knowledge base output
### Task 3: Support filtering by pattern type
- [ ] Support filtering by pattern type
### Task 4: Add search functionality
- [ ] Add search functionality
### Task 5: Include statistics (total patterns, usage)
- [ ] Include statistics (total patterns, usage)
### Task 6: Write Pest tests for command
- [ ] Write Pest tests for command

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
