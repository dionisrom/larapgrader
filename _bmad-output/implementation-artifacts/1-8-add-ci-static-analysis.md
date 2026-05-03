# Story 1.8: Add CI Static Analysis Gate

**Epic:** Epic 1 - Project Initialization & Infrastructure  
**Status:** ready-for-dev  
**Priority:** HIGH (deferred from story 1.4 AC4)  
**Complexity:** Medium (3 tasks)  
**Dependencies:** Story 1.4 (Configure PHPStan) ✅

---

## Overview

Implement GitHub Actions CI/CD workflow to automatically run PHPStan (level 8) and php-cs-fixer checks on pull requests and commits. This enforces code quality standards at the CI gate, preventing violations from merging to main.

**Deferred From:** Story 1.4, Acceptance Criteria #4  
**Reason:** Out of scope for local tool configuration; CI integration is separate concern  
**Requested In:** Code review of story 1.4 (2026-05-03)

---

## Context

Story 1.4 configured code quality tools locally:
- ✅ PHPStan level 8 (phpstan.neon)
- ✅ PSR-12 standard via php-cs-fixer (.php-cs-fixer.php)
- ✅ Test suite (Pest PHP)

This story automates enforcement via GitHub Actions, ensuring all PRs pass quality gates before merge.

---

## Acceptance Criteria

**AC1:** GitHub Actions workflow file exists at `.github/workflows/code-quality.yml`

**AC2:** Workflow runs on `push` to main/develop and all pull requests

**AC3:** Workflow executes `vendor/bin/phpstan analyse src/ --level 8` and fails if errors found

**AC4:** Workflow executes `vendor/bin/php-cs-fixer check --diff` and fails if violations found

**AC5:** Workflow provides clear pass/fail status in GitHub PR checks (green ✓ / red ✗)

**AC6:** CI workflow passes for the current codebase (0 PHPStan errors, 0 style violations)

---

## Tasks

### Task 1: Create GitHub Actions Workflow File

**Description:** Create `.github/workflows/code-quality.yml` workflow that defines the CI pipeline

**Details:**
- Use ubuntu-latest runner
- Set up PHP 8.3
- Install Composer dependencies
- Configure cache for Composer
- Define two jobs: `phpstan` and `php-cs-fixer`

**Acceptance:**
- [ ] File exists at `.github/workflows/code-quality.yml`
- [ ] Workflow syntax is valid (no YAML errors)
- [ ] Workflow runs on `push` and `pull_request` triggers

---

### Task 2: Implement PHPStan CI Check

**Description:** Add PHPStan job to workflow that validates src/ at level 8

**Details:**
- Job name: `phpstan`
- Run: `vendor/bin/phpstan analyse src/ --level 8`
- On failure: Post error message with line/file details
- Timeout: 5 minutes
- Should NOT fail on warnings, only errors

**Acceptance:**
- [ ] Job runs successfully
- [ ] Reports errors in GitHub PR checks
- [ ] Failure blocks PR merge

---

### Task 3: Implement PHP-CS-Fixer CI Check

**Description:** Add php-cs-fixer job to workflow that validates PSR-12 compliance

**Details:**
- Job name: `php-cs-fixer`
- Run: `vendor/bin/php-cs-fixer check --diff`
- On failure: Post diff showing violations
- Timeout: 5 minutes
- Should NOT fail on warnings, only violations

**Acceptance:**
- [ ] Job runs successfully
- [ ] Reports violations in GitHub PR checks
- [ ] Failure blocks PR merge
- [ ] Diff is human-readable in PR comments

---

## Architecture Notes

**Trigger Events:**
- `push` to branches: `main`, `develop`
- `pull_request` to any branch

**Runner:** `ubuntu-latest` (Linux environment, consistent with MVP deployments)

**PHP Version:** 8.3 (matches project requirement)

**Caching:** Enable Composer cache to speed up CI runs

**Artifact:** Store workflow results for audit trail (optional)

---

## Testing Strategy

1. **Local:** Validate workflow syntax with `act` (GitHub Actions emulator) or dry-run
2. **GitHub:** Create test PR to verify workflow executes and provides clear feedback
3. **Regression:** Run existing tests to ensure no regressions

---

## Success Criteria

- ✅ Workflow file created and syntactically valid
- ✅ PHPStan job passes on current codebase (0 errors)
- ✅ PHP-CS-Fixer job passes on current codebase (0 violations)
- ✅ PR checks appear in GitHub UI with clear pass/fail status
- ✅ Tests pass (no regression)

---

## Related Work

**Previous Stories:**
- 1.1: Initialize Composer project ✅
- 1.2: Create Service Container ✅
- 1.3: Setup Pest PHP ✅
- 1.4: Configure PHPStan ✅ (provides tooling this story automates)

**Future Stories:**
- 1.5: Implement Ollama CLI
- 1.6: Create Onboarding Wizard
- 1.7: Generate README.md

---

## Status

**Current Status:** ready-for-dev  
**Last Updated:** 2026-05-03  
**Created From:** Story 1.4 code review (AC4 deferral)  
**Next Action:** Pick up for development when ready
