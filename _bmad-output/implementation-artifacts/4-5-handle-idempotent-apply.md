---
story_key: "4-5-handle-idempotent-apply"
epic: "Epic 4: Phase A - Lumen 8 → Laravel 8 Migration"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 4-5-handle-idempotent-apply: Handle idempotent/resumable apply

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Handle idempotent/resumable apply following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR21
- NFR10

---

## Acceptance Criteria

### AC 1: Migration is idempotent and resumable (FR21)
- [ ] Migration is idempotent and resumable (FR21)
### AC 2: Survives interruption (kill, power loss) (NFR10)
- [ ] Survives interruption (kill, power loss) (NFR10)
### AC 3: State registry tracks applied transformations
- [ ] State registry tracks applied transformations
### AC 4: Resume from last successful state
- [ ] Resume from last successful state
### AC 5: Atomic state writes (NFR11)
- [ ] Atomic state writes (NFR11)

---

## Tasks/Subtasks

### Task 1: Enhance state registry for progress tracking
- [ ] Enhance state registry for progress tracking
### Task 2: Check state before applying each transformation
- [ ] Check state before applying each transformation
### Task 3: Skip already-applied transformations
- [ ] Skip already-applied transformations
### Task 4: Use atomic writes for state updates (NFR11)
- [ ] Use atomic writes for state updates (NFR11)
### Task 5: Handle interruption gracefully
- [ ] Handle interruption gracefully
### Task 6: Write Pest tests for resume scenarios
- [ ] Write Pest tests for resume scenarios

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
