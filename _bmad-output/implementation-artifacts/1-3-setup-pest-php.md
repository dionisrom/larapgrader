---
story_key: "1-3-setup-pest-php"
epic: "Epic 1: Project Initialization & Infrastructure"
status: "done"
last_updated: "2026-05-03"
---

# Story 1-3-setup-pest-php: Set up Pest PHP with TestCase.php and helpers

**User Value:** Marco (engineer) can use larapgrader to migrate Lumen apps to Laravel with confidence.

---

## Story

Set up Pest PHP with TestCase.php and helpers following the requirements from the Architecture and PRD documents.

### Requirements Mapping:
- A7: Use Pest PHP for all tool tests
- A27: Pest tests use `test()` + `expect()` syntax
- A28: External dependencies must be mocked in tests
- A26: All new tests pass before story completion
- A30: Coverage report supported (target 80%+)

---

## Acceptance Criteria

### AC 1: Pest baseline configuration is valid (A7, A27)
- [x] `composer.json` includes `pestphp/pest` in `require-dev`
- [x] `pest.php` exists and contains `uses(Tests\\TestCase::class);`
- [x] At least one project test file uses `test()` + `expect()` syntax

### AC 2: Base TestCase is present and reusable
- [x] `tests/TestCase.php` extends `PHPUnit\\Framework\\TestCase`
- [x] `tests/TestCase.php` contains shared setup hook(s) for future tests (`setUp()` or documented extension point)

### AC 3: Helper scaffold is concrete and usable
- [x] `tests/Helpers/` contains at least one helper artifact (`tests/Helpers/TestDataFactory.php` or equivalent)
- [x] A test demonstrates helper usage (import/call/assert)

### AC 4: Mocking standard is enforceable (A28)
- [x] Story includes one concrete test example using Mockery for an external dependency contract
- [x] Guidance explicitly states no live external calls in unit tests

### AC 5: Verification commands are explicit and reproducible
- [x] `vendor/bin/pest --version` succeeds
- [x] `vendor/bin/pest tests/` succeeds (100% pass for story scope)

### AC 6: Coverage path is defined and non-blocking (A30)
- [x] Story includes coverage command (`vendor/bin/pest --coverage`)
- [x] Story documents required coverage driver (Xdebug or PCOV) and marks driver installation as environment prerequisite
- [x] If driver is absent, story remains implementable and prerequisite follow-up is documented for environments where coverage must be reported

---

## Tasks/Subtasks

### Task 1: Verify and normalize existing Pest baseline
- [x] Confirm `pestphp/pest` and `mockery/mockery` entries in `composer.json`
- [x] Confirm `pest.php` loads `Tests\\TestCase`

### Task 2: Harden `tests/TestCase.php` for future suites
- [x] Keep `tests/TestCase.php` as single base class for project tests
- [x] Add minimal shared setup extension point (no framework-specific coupling)

### Task 3: Add concrete helper scaffold
- [x] Create `tests/Helpers/TestDataFactory.php` (or equivalent) with deterministic fixture builders
- [x] Document helper usage in a test docblock/comment

### Task 4: Add seed tests that prove setup quality
- [x] Add/adjust one smoke test proving Pest runtime + assertions
- [x] Add one test using Mockery for external dependency behavior (A28)

### Task 5: Add explicit verification step
- [x] Run `vendor/bin/pest --version`
- [x] Run `vendor/bin/pest tests/`

### Task 6: Define coverage prerequisite and execution path
- [x] Add coverage command guidance (`vendor/bin/pest --coverage`)
- [x] Add prerequisite note: Xdebug or PCOV must be installed/enabled
- [x] Record expected handling when driver is unavailable

### Review Findings

- [x] [Review][Patch] Missing explicit no-live-external-calls policy in helper guidance [tests/Helpers/README.md:3]
- [x] [Review][Patch] Deterministic helper test does not verify repeat-call determinism or full fixture shape [tests/Setup/PestSetupTest.php:7]
- [x] [Review][Patch] Story acceptance criteria checkboxes are inconsistent with completed tasks/status [ _bmad-output/implementation-artifacts/1-3-setup-pest-php.md:29 ]
- [x] [Review][Patch] Task claims helper usage docblock/comment, but test lacks that documentation note [tests/Setup/PestSetupTest.php:7]
- [x] [Review][Defer] sprint-status file extension/content mismatch may break tools expecting strict YAML parse [ _bmad-output/implementation-artifacts/sprint-status.yaml:1 ] — deferred, pre-existing

---

## Dev Agent Record (Debug Log)

### Implementation Plan
1. Validate current Pest baseline (`composer.json`, `pest.php`, `tests/TestCase.php`)
2. Add concrete helper artifact under `tests/Helpers/`
3. Add minimal proof tests for syntax, helper usage, and mocking policy
4. Run and capture verification commands for reproducibility
5. Document coverage prerequisite and command behavior

### Technical Decisions
- Keep Story 1.3 focused on testing infrastructure only
- Reuse existing baseline artifacts from Story 1.1 when present
- Prefer deterministic helper fixtures over inline random data in tests
- Treat coverage driver as environment prerequisite, not implementation code

### Edge Cases
- Coverage driver missing (`vendor/bin/pest --coverage` fails without Xdebug/PCOV)
- Helper files exist but are unused (must include at least one usage example)
- Baseline files already exist and should be augmented, not recreated

### Completion Notes
- Implemented helper scaffold with deterministic fixtures in `tests/Helpers/TestDataFactory.php`.
- Added setup-focused Pest tests in `tests/Setup/PestSetupTest.php` to validate helper usage and Mockery-based external dependency isolation.
- Hardened shared `tests/TestCase.php` with explicit `setUp()` and safe Mockery cleanup in `tearDown()`.
- Verified commands: `vendor/bin/pest --version`, `vendor/bin/pest tests/`, and `vendor/bin/pest tests/Setup/PestSetupTest.php` all succeeded.
- Verified expected coverage behavior: `vendor/bin/pest --coverage` fails in current environment because no coverage driver is available.

---

## File List

### Created Files
- `tests/Helpers/TestDataFactory.php` (or equivalent concrete helper file)
- `tests/Helpers/README.md` (optional helper conventions)
- `tests/Setup/PestSetupTest.php` (seed tests demonstrating helper usage and Mockery-based isolation)

### Modified Files
- `tests/TestCase.php` (shared setup/teardown extension points)

### Verification Commands
- `vendor/bin/pest --version`
- `vendor/bin/pest tests/`
- `vendor/bin/pest --coverage` (requires Xdebug or PCOV)

---

## Change Log

### 2026-05-03: Story Created
- Story file created from Epic 1: Project Initialization & Infrastructure
- All requirements mapped from Architecture and PRD documents
- Acceptance Criteria defined with checkboxes
- Tasks broken down into actionable items
- Dev Agent Record includes implementation plan and edge cases

### 2026-05-03: Story Validated and Tightened
- Added measurable acceptance criteria with explicit pass/fail checks
- Added concrete helper artifact expectation for `tests/Helpers/`
- Added explicit verification commands for local reproducibility
- Added coverage-driver prerequisite guidance (Xdebug/PCOV)
- Reduced unrelated scope in technical decisions for better dev-agent focus

### 2026-05-03: Story Implemented (Ready for Review)
- Completed all story tasks for Pest setup hardening and helper scaffolding.
- Added deterministic test helper factory and helper conventions documentation.
- Added setup verification tests for helper usage and Mockery contract mocking.
- Updated base test case with reusable setup/teardown and automatic Mockery cleanup.
- Executed full project tests successfully; coverage command remains blocked by missing Xdebug/PCOV in environment.

---

## Status

**Current Status:** done
**Last Updated:** 2026-05-03
**Completed Tasks:** 6/6
**Next Action:** Begin next ready-for-dev story (1.4 Configure PHPStan)
