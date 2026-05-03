---
story_key: "2-8-add-llm-explanations"
epic: "Epic 2: Pre-Migration Intelligence"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 2-8-add-llm-explanations: Add LLM-powered plain-English explanations

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Add LLM-powered plain-English explanations following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- A4
- FR5
- A25

---

## Acceptance Criteria

### AC 1: Uses Ollama CLI for explanations (A4)
- [ ] Uses Ollama CLI for explanations (A4)
### AC 2: Explains confidence scores in plain English (FR5)
- [ ] Explains confidence scores in plain English (FR5)
### AC 3: Logs all prompts to audit trail (A25)
- [ ] Logs all prompts to audit trail (A25)
### AC 4: Graceful degradation if LLM unavailable (NFR17)
- [ ] Graceful degradation if LLM unavailable (NFR17)
### AC 5: Explanations are clear and actionable
- [ ] Explanations are clear and actionable

---

## Tasks/Subtasks

### Task 1: Extend ConfidenceScorerService with LLM integration
- [ ] Extend ConfidenceScorerService with LLM integration
### Task 2: Craft effective prompts for Mistral model
- [ ] Craft effective prompts for Mistral model
### Task 3: Parse LLM responses into explanations
- [ ] Parse LLM responses into explanations
### Task 4: Handle LLM errors gracefully
- [ ] Handle LLM errors gracefully
### Task 5: Log all prompts and responses (A25)
- [ ] Log all prompts and responses (A25)
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
