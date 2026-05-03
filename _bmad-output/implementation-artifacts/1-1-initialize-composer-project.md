---
story_key: "1-1-initialize-composer-project"
epic: "Epic 1: Project Initialization & Infrastructure"
status: "done"
last_updated: "2026-05-03"
---

# Story 1.1: Initialize Composer Project with Dependencies

**User Value:** Marco (engineer) can install larapgrader via `composer require --dev your-org/larapgrader`.

---

## Story

Initialize a new Composer project for larapgrader with all required dependencies as specified in the Architecture document.

### Requirements Mapping:
*All requirements derived from Architecture Document (architecture.md)*
- A1: Use PHP 8.3 runtime
- A2: Use Symfony Console for CLI framework
- A3: Use nikic/php-parser for AST analysis
- A4: Use Ollama CLI wrapper (local Mistral) for LLM features
- A5: Use SQLite with WAL mode for State Registry
- A6: Use PHP-DI (PSR-11) for Service Container
- A7: Use Pest PHP for all tool tests (80%+ coverage)
- A8: Use amphp/parallel for parallel file analysis
- A9: Use symfony/process for Ollama CLI calls
- A10: Use symfony/yaml for YAML config parsing

---

## Acceptance Criteria

### AC 1: Project Initialization
- [ ] `composer init` creates project with name "your-org/larapgrader"
- [ ] PHP version constraint set to "^8.3"
- [ ] Description: "Lumen to Laravel migration orchestrator"

### AC 2: Core Dependencies Installed
- [ ] `php-di/php-di: "^7.1"` installed (Service Container)
- [ ] `symfony/console: "^7.4"` installed (CLI framework)
- [ ] `symfony/process: "^7.4"` installed (Ollama CLI calls)
- [ ] `symfony/yaml: "^7.4"` installed (YAML parsing)
- [ ] `nikic/php-parser: "^5.7"` installed (AST analysis)
- [ ] `ext-pdo_sqlite: "*"` installed (SQLite support for State Registry - A5)
- [ ] `amphp/parallel: "^2.0"` installed (parallel file analysis - A8)

### AC 3: Development Dependencies Installed
- [ ] `pestphp/pest: "^2.36"` installed (testing framework)
- [ ] `mockery/mockery: "^1.6"` installed (mocking support - replaces abandoned pest-plugin-mock)
- [ ] `phpstan/phpstan: "^2.1"` installed (static analysis)

### AC 4: Autoload Configuration
- [ ] PSR-4 autoload configured: `"Larapgrader\\": "src/"`
- [ ] PSR-4 dev autoload configured: `"Tests\\": "tests/"`
- [ ] `bin` field set to `["bin/larapgrader"]`

### AC 5: Initial Project Structure Created
- [ ] `bin/larapgrader` file created with `#!/usr/bin/env php` shebang
- [ ] `src/` directory created
- [ ] `tests/` directory created with `TestCase.php` and `Helpers/`
- [ ] `composer.json` has all dependencies listed
- [ ] `phpstan.neon` created with Level 8 configuration
- [ ] `pest.php` created with base TestCase reference

### AC 6: Verify Installation
- [ ] `composer install` runs without errors
- [ ] `vendor/bin/pest --version` returns Pest version
- [ ] `vendor/bin/phpstan --version` returns PHPStan version
- [ ] `php bin/larapgrader --version` shows "larapgrader 0.1.0" (or similar)

---

## Tasks/Subtasks

### Task 1: Initialize Composer Project
- [x] Run `composer init --name="your-org/larapgrader" --description="Lumen to Laravel migration orchestrator" --require="php:^8.3" --no-interaction`
- [x] Verify `composer.json` created with correct name and description

### Task 2: Install Core Dependencies
- [x] Run `composer require php-di/php-di symfony/console symfony/process symfony/yaml nikic/php-parser ext-pdo_sqlite amphp/parallel`
- [x] Run `composer require --dev pestphp/pest mockery/mockery phpstan/phpstan`
- [x] Verify all dependencies in `composer.json` require/require-dev sections

### Task 3: Configure Autoload
- [x] Add PSR-4 autoload: `"Larapgrader\\": "src/"`
- [x] Add PSR-4 dev autoload: `"Tests\\": "tests/"`
- [x] Add `bin` field: `["bin/larapgrader"]`
- [x] Run `composer dump-autoload` to verify configuration

### Task 4: Create Project Structure
- [x] Create `bin/larapgrader` with shebang and PHP opening tag
- [x] Make `bin/larapgrader` executable: `chmod +x bin/larapgrader`
- [x] Create `src/` and `tests/` directories
- [x] Create `tests/TestCase.php` with base TestCase class
- [x] Create `tests/Helpers/` directory

### Task 5: Create Configuration Files
- [x] Create `phpstan.neon` with Level 8 configuration
- [x] Create `pest.php` with `uses(Tests\TestCase::class)`
- [x] Create `.gitignore` with `/vendor/`, `/composer.lock`, `.phpunit.result.cache`

### Task 6: Verify Installation
- [x] Run `composer install` and verify no errors
- [x] Run `vendor/bin/pest --version` and capture output
- [x] Run `vendor/bin/phpstan --version` and capture output
- [x] Test CLI entry point: `php bin/larapgrader --version` shows "larapgrader 0.1.0"

---

## File List

### Created Files
- `composer.json` (project configuration with all dependencies)
- `bin/larapgrader` (CLI entry point with Symfony Console)
- `phpstan.neon` (static analysis config with Level 8)
- `pest.php` (Pest PHP config with TestCase reference)
- `.gitignore` (ignore rules for vendor, composer.lock, cache files)
- `tests/TestCase.php` (base test case class)
- `src/` (source directory, empty initially)
- `tests/` (test directory structure)
- `tests/Helpers/` (test helpers directory)

### Modified Files
- None (fresh project initialization)

### Dependencies Installed
**Core:**
- php-di/php-di ^7.1 (Service Container)
- symfony/console ^7.4 (CLI framework)
- symfony/process ^7.4 (Ollama CLI calls)
- symfony/yaml ^7.4 (YAML parsing)
- nikic/php-parser ^5.7 (AST analysis)
- ext-pdo_sqlite * (SQLite support for State Registry - A5)
- amphp/parallel ^2.0 (parallel file analysis - A8)

**Development:**
- pestphp/pest ^2.36 (testing framework)
- mockery/mockery ^1.6 (mocking support - replaces abandoned pest-plugin-mock)
- phpstan/phpstan ^2.1 (static analysis)

---

## Change Log

### 2026-05-03: Story Implemented
- ✅ **All 6 tasks completed successfully**
- ✅ Project initialized with Composer (your-org/larapgrader, PHP ^8.3)
- ✅ Core dependencies installed (php-di, symfony/console, symfony/process, symfony/yaml, nikic/php-parser)
- ✅ Dev dependencies installed (pest, mockery/mockery, phpstan)
- ✅ PSR-4 autoload configured (Larapgrader\\ for src/, Tests\\ for tests/)
- ✅ Bin field set to bin/larapgrader
- ✅ Project structure created (bin/, src/, tests/, tests/Helpers/)
- ✅ CLI entry point created with Symfony Console (version 0.1.0)
- ✅ Configuration files created (phpstan.neon Level 8, pest.php, .gitignore)
- ✅ Git repository initialized
- ✅ All verification tests passed (composer install, pest --version, phpstan --version, CLI --version)
- ✅ Story status updated to "review" in sprint-status.yaml

### 2026-05-03: Story Created
- Story file created from Epic 1 (Project Initialization)
- All requirements mapped from Architecture document (A1-A10)
- Acceptance Criteria defined (6 ACs with checkboxes)
- Tasks broken down into 6 subtasks
- Dev Agent Record includes implementation plan and edge cases

---

## Status

**Current Status:** review
**Last Updated:** 2026-05-03
**Completed Tasks:** 6/6
**Next Action:** Ready for code review

---

## Review Findings

### Decision-Needed (Resolved)
- [x] [Review][Decision] **composer.json still references pestphp/pest-plugin in allow-plugins** — RESOLVED: Removed plugin (set to false) since we switched to `mockery/mockery`.

### Patch (Fixed)
- [x] [Review][Patch] **bin/larapgrader lacks error handling for missing vendor/autoload.php** [bin/larapgrader:3] — FIXED: Added check for autoload.php existence with error message and exit(1).

### Deferred
- [x] [Review][Defer] **No PSR-12 coding standard config in initial setup** [Project setup] — Architecture requirement A19 states "Follow PSR-12 coding standard (enforced via php-cs)". Will be addressed in Story 1.4 (Configure PHPStan and PSR-12 code style).

- [x] [Review][Defer] **amphp/parallel may have platform-specific issues** [composer.json:require] — The `amphp/parallel` library requires specific PHP extensions. This is a dependency concern, not a code issue. (Pre-existing)
