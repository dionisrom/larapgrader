---
story_key: "2-5-detect-incompatible-packages"
epic: "Epic 2: Pre-Migration Intelligence"
status: "ready-for-dev"
last_updated: "2026-05-03"
---

# Story 2-5-detect-incompatible-packages: Detect incompatible packages

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Detect incompatible packages following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- FR8

---

## Acceptance Criteria

### AC 1: Scans composer.json for incompatible packages (FR8)
- [ ] Scans composer.json for incompatible packages (FR8)
### AC 2: Checks against known Lumen/Laravel compatibility matrix
- [ ] Checks against known Lumen/Laravel compatibility matrix
### AC 3: Flags packages requiring manual review
- [ ] Flags packages requiring manual review
### AC 4: Outputs list with compatibility status
- [ ] Outputs list with compatibility status
### AC 5: Suggests replacement packages where available
- [ ] Suggests replacement packages where available

---

## Tasks/Subtasks

### Task 1: Create src/Services/PackageCompatibilityChecker.php
- [ ] Create src/Services/PackageCompatibilityChecker.php
### Task 2: Define compatibility matrix for common packages
- [ ] Define compatibility matrix for common packages
### Task 3: Parse composer.json and vendor/ directory
- [ ] Parse composer.json and vendor/ directory
### Task 4: Flag incompatible or deprecated packages
- [ ] Flag incompatible or deprecated packages
### Task 5: Generate compatibility report
- [ ] Generate compatibility report
### Task 6: Write Pest tests with sample composer.json files
- [ ] Write Pest tests with sample composer.json files

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
