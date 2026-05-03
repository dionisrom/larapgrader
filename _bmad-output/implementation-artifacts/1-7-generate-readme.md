---
story_key: "1-7-generate-readme"
epic: "Epic 1: Project Initialization & Infrastructure"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 1-7-generate-readme: Generate README.md with detailed sections

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Generate README.md with detailed sections following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- UX

---

## Acceptance Criteria

### AC 1: README.md has Installation section
- [ ] README.md has Installation section
### AC 2: README.md has Quick Start guide
- [ ] README.md has Quick Start guide
### AC 3: README.md has Commands documentation
- [ ] README.md has Commands documentation
### AC 4: README.md has Troubleshooting section
- [ ] README.md has Troubleshooting section
### AC 5: Badges for CI, coverage, version
- [ ] Badges for CI, coverage, version
### AC 6: Examples of analyse and migrate commands
- [ ] Examples of analyse and migrate commands

---

## Tasks/Subtasks

### Task 1: Create README.md with project description
- [ ] Create README.md with project description
### Task 2: Add Installation section (composer require)
- [ ] Add Installation section (composer require)
### Task 3: Add Quick Start guide with first-run wizard
- [ ] Add Quick Start guide with first-run wizard
### Task 4: Document all CLI commands (analyse, migrate, etc.)
- [ ] Document all CLI commands (analyse, migrate, etc.)
### Task 5: Add Troubleshooting section
- [ ] Add Troubleshooting section
### Task 6: Add badges and examples
- [ ] Add badges and examples

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
- Story file created from Epic 1: Project Initialization & Infrastructure
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
