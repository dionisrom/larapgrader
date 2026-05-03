---
story_key: "2-1-build-ast-parser"
epic: "Epic 2: Pre-Migration Intelligence"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 2-1-build-ast-parser: Build AST Parser with parallel processing

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Build AST Parser with parallel processing following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- A3
- A8
- NFR1
- NFR2
- FR3

---

## Acceptance Criteria

### AC 1: AST Parser uses nikic/php-parser (A3)
- [ ] AST Parser uses nikic/php-parser (A3)
### AC 2: Parallel processing via amphp/parallel (A8)
- [ ] Parallel processing via amphp/parallel (A8)
### AC 3: Completes 100k lines in ≤5 min (NFR1)
- [ ] Completes 100k lines in ≤5 min (NFR1)
### AC 4: migrate plan completes in ≤3 min (NFR2)
- [ ] migrate plan completes in ≤3 min (NFR2)
### AC 5: Parses Lumen 8 codebase correctly (FR3)
- [ ] Parses Lumen 8 codebase correctly (FR3)
### AC 6: Returns structured AST representation
- [ ] Returns structured AST representation

---

## Tasks/Subtasks

### Task 1: Create src/Contracts/AstParserInterface.php (if not exists)
- [ ] Create src/Contracts/AstParserInterface.php (if not exists)
### Task 2: Implement src/Services/AstParserService.php with nikic/php-parser
- [ ] Implement src/Services/AstParserService.php with nikic/php-parser
### Task 3: Integrate amphp/parallel for concurrent file processing
- [ ] Integrate amphp/parallel for concurrent file processing
### Task 4: Add progress reporting for long operations
- [ ] Add progress reporting for long operations
### Task 5: Write Pest tests with sample PHP files
- [ ] Write Pest tests with sample PHP files
### Task 6: Benchmark against 100k line codebase
- [ ] Benchmark against 100k line codebase

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
