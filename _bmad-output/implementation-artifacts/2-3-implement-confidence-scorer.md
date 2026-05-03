---
story_key: "2-3-implement-confidence-scorer"
epic: "Epic 2: Pre-Migration Intelligence"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 2-3-implement-confidence-scorer: Implement confidence scoring engine

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Implement confidence scoring engine following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR5
- A25
- A4

---

## Acceptance Criteria

### AC 1: Scores migration confidence 0-100 (FR5)
- [ ] Scores migration confidence 0-100 (FR5)
### AC 2: Plain-English explanation via LLM (A4, FR5)
- [ ] Plain-English explanation via LLM (A4, FR5)
### AC 3: Logs all LLM prompts to audit trail (A25)
- [ ] Logs all LLM prompts to audit trail (A25)
### AC 4: Factors: code complexity, dependencies, test coverage
- [ ] Factors: code complexity, dependencies, test coverage
### AC 5: Output includes score + explanation
- [ ] Output includes score + explanation

---

## Tasks/Subtasks

### Task 1: Create src/Contracts/ConfidenceScorerInterface.php (if not exists)
- [ ] Create src/Contracts/ConfidenceScorerInterface.php (if not exists)
### Task 2: Implement src/Services/ConfidenceScorerService.php
- [ ] Implement src/Services/ConfidenceScorerService.php
### Task 3: Calculate base score from code analysis
- [ ] Calculate base score from code analysis
### Task 4: Call Ollama CLI for explanation generation (A4)
- [ ] Call Ollama CLI for explanation generation (A4)
### Task 5: Log prompts to audit trail (A25)
- [ ] Log prompts to audit trail (A25)
### Task 6: Write Pest tests with mocked Ollama CLI
- [ ] Write Pest tests with mocked Ollama CLI

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
