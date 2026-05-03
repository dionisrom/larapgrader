---
story_key: "2-2-create-symbol-index"
epic: "Epic 2: Pre-Migration Intelligence"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 2-2-create-symbol-index: Create cross-file symbol index

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Create cross-file symbol index following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR2

---

## Acceptance Criteria

### AC 1: Symbol Index stores class/function/method definitions (FR2)
- [ ] Symbol Index stores class/function/method definitions (FR2)
### AC 2: Cross-file reference tracking
- [ ] Cross-file reference tracking
### AC 3: Fast lookup by symbol name
- [ ] Fast lookup by symbol name
### AC 4: Supports namespace resolution
- [ ] Supports namespace resolution
### AC 5: Persisted to SQLite state registry (A5)
- [ ] Persisted to SQLite state registry (A5)

---

## Tasks/Subtasks

### Task 1: Create src/Contracts/SymbolIndexInterface.php (if not exists)
- [ ] Create src/Contracts/SymbolIndexInterface.php (if not exists)
### Task 2: Implement src/Services/SymbolIndexService.php
- [ ] Implement src/Services/SymbolIndexService.php
### Task 3: Index classes, functions, methods, and constants
- [ ] Index classes, functions, methods, and constants
### Task 4: Build cross-reference map
- [ ] Build cross-reference map
### Task 5: Store index in SQLite database (A5)
- [ ] Store index in SQLite database (A5)
### Task 6: Write Pest tests with sample codebase
- [ ] Write Pest tests with sample codebase

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
- Story file created from Epic 2: Pre-Migration Intelligence
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
