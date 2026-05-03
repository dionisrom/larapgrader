---
stepsCompleted: [step-01-validate-prerequisites, step-02-design-epics, step-03-break-stories]
inputDocuments: ['_bmad-output/planning-artifacts/prd.md', '_bmad-output/planning-artifacts/architecture.md']
workflowType: 'epics'
project_name: 'larapgrader'
user_name: 'Boggie'
date: '2026-05-02'
---

# Epics & Stories - larapgrader

_This document breaks down the PRD requirements into epics and user stories, organized by user value. Each story has clear acceptance criteria for the Developer agent._

---

## Requirements Coverage Map

### Functional Requirements (49 FRs) Extracted:

**FR Area 1: Pre-Migration Analysis (FR1-FR9)**
- FR1: Analyse single app → Pre-Migration Intelligence Report
- FR2: Pre-analysis indexing pass (cross-file symbol index)
- FR3: Parse Lumen 8 codebase using AST analysis
- FR4: Classify patterns (auto-migratable / review / incompatible)
- FR5: Calculate confidence score with plain-English explanation
- FR6: Generate blast radius map with cascading chains
- FR7: Produce time and effort estimate
- FR8: Detect incompatible custom packages
- FR9: Output Pre-Migration Intelligence Report (human-readable)

**FR Area 2: Migration Planning & Dry-Run (FR10-FR16)**
- FR10: Generate dry-run diff (migrate plan)
- FR11: Present proposed changes file by file with confidence scores
- FR12: Review flagged items below auto-migrate threshold
- FR13: Scaffold Migration Contract with defaults
- FR14: Author Migration Contract (thresholds, protected files, approval gates)
- FR15: Migration Contract must be versionable YAML in repo
- FR16: Refuse to proceed without valid Migration Contract

**FR Area 3: Migration Execution (FR17-FR27)**
- FR17: Execute migration plan (migrate apply)
- FR18: Automatic rollback snapshot before apply
- FR19: View snapshot registry with labels and timestamps
- FR20: Manual rollback to named snapshot
- FR21: Idempotent, resumable apply (failure recovery)
- FR22: Execute Phase A and Phase B as discrete steps
- FR23: Prevent Phase B until Phase A validated
- FR24: Apply Phase A via composable rule registry (AST)
- FR25: Apply Phase B via Rector + custom audit layer
- FR26: Detect manually modified migrated files
- FR27: Halt and log contract violation for mid-migration breaches

**FR Area 4: Validation & Quality Gates (FR28-FR34)**
- FR28: Configure external shell command (post_phase_command)
- FR29: Halt migration if post_phase_command fails
- FR30: Display last modified file and diff on failure
- FR31: Log post_phase_command execution to audit trail
- FR32: Validate git repository exists before transformation
- FR33: Check for dirty working directory before apply
- FR34: Execute smoke test after Phase A (php artisan --version)

**FR Area 5: Knowledge Capture & Pattern Resolution (FR35-FR38)**
- FR35: Prompt to generalise resolved patterns
- FR36: Confirm/reject generalisation before applying to similar cases
- FR37: Store resolved patterns in knowledge base
- FR38: View accumulated knowledge base

**FR Area 6: Governance & Audit (FR39-FR42)**
- FR39: Record transformation decisions to audit trail
- FR40: Record human approval/rejection to audit trail
- FR41: Export full audit trail for compliance
- FR42: Never include .env contents in reports or logs

**FR Area 7: CLI Interface & Configuration (FR43-FR49)**
- FR43: Comprehensive --help output (description, flags, examples, exit codes)
- FR44: Meaningful exit codes (0=success, 1=confidence gate, 2=error, 3=human review)
- FR45: Support --no-ansi flag for CI/logging
- FR46: Support --verbose and --quiet flags
- FR47: Read tool config from larapgrader.yaml
- FR48: All file path operations work on Windows/macOS/Linux
- FR49: Detect and warn when vendor/ directory missing or stale

---

### Non-Functional Requirements (20 NFRs) Extracted:

**Performance (NFR1-NFR4)**
- NFR1: analyse completes 100k lines in ≤5 min
- NFR2: migrate plan completes in ≤3 min for single app layer
- NFR3: migrate apply streams progress for long operations (>60s)
- NFR4: State registry overhead ≤5s per command

**Security (NFR5-NFR9)**
- NFR5: AST core makes zero outbound network calls
- NFR6: LLM features transmit only selected code snippets
- NFR7: Never read/log/.env contents
- NFR8: Audit trail is append-only (existing entries not modifiable)
- NFR9: Log all AI prompt payloads locally before transmission

**Reliability (NFR10-NFR13)**
- NFR10: migrate apply survives interruption (kill, power loss)
- NFR11: State registry uses atomic writes (no partial writes)
- NFR12: Preserve file changes if post_phase_command fails
- NFR13: Rollback restores exact pre-apply state

**Integration (NFR14-NFR17)**
- NFR14: post_phase_command supports any shell command
- NFR15: Git 2.30+ supported (branch/stash workflows)
- NFR16: Rector version pinned in composer.json
- NFR17: LLM features degrade gracefully if endpoint unreachable

**Scale (NFR18-NFR20)**
- NFR18: Handles 500 files / 150k lines without config changes
- NFR19: Warn (not fail) for larger codebases
- NFR20: Memory consumption ≤512MB peak on recommended hardware

---

### Additional Requirements from Architecture Document:

**Tech Stack & Infrastructure:**
- A1: Use PHP 8.3 runtime (tool and target apps)
- A2: Use Symfony Console for CLI framework
- A3: Use nikic/php-parser for AST analysis
- A4: Use Ollama CLI wrapper (local Mistral) for LLM features
- A5: Use SQLite with WAL mode for State Registry (concurrency-safe)
- A6: Use PHP-DI (PSR-11) for Service Container
- A7: Use Pest PHP for all tool tests (80%+ coverage)
- A8: Use amphp/parallel for parallel file analysis
- A9: Use symfony/process for Ollama CLI calls
- A10: Use symfony/yaml for YAML config parsing

**Project Structure & Boundaries:**
- A11: PSR-4 autoload: Larapgrader\\ → src/
- A12: Tests mirror src/ structure exactly
- A13: All 10+ interfaces in src/Contracts/
- A14: Hierarchical exceptions in src/Exceptions/
- A15: Service Container in src/Container/ServiceContainer.php
- A16: FileManager in src/Files/FileManager.php
- A17: Onboarding Wizard in src/Onboarding/FirstRunWizard.php
- A18: Domain Model in src/Domain/DomainLoader.php

**Implementation Patterns:**
- A19: Follow PSR-12 coding standard (enforced via php-cs)
- A20: Use constructor injection (not `new` in methods)
- A21: Name JSON keys in snake_case (not camelCase)
- A22: Use Symfony Console output methods (not `echo`)
- A23: Return named exit code constants (not magic numbers)
- A24: Atomic state writes (temp file + rename)
- A25: Log all LLM prompts to audit trail before sending

**Quality & Testing:**
- A26: All new tests must pass 100% before story complete
- A27: Pest PHP tests use test() + expect() syntax
- A28: Mock all external dependencies in Pest tests
- A29: Run phpstan --level=8 in CI
- A30: Generate coverage report (target 80%+)

---

## Epic Structure (Organized by User Value)

### Epic 1: Project Initialization & Infrastructure (Boggie's First Setup) ✅ MVP

**User Value:** Marco (engineer) can install larapgrader and run it for the first time with guided setup.

**Stories:**
1. **Story 1.1:** Initialize Composer project with dependencies (A1-A10)
2. **Story 1.2:** Create Service Container with all interfaces (A6, A13)
   - 1.2.1: Define all 10 interfaces in `src/Contracts/`
   - 1.2.2: Implement ServiceContainer with PHP-DI
   - 1.2.3: Write Pest tests for container
3. **Story 1.3:** Set up Pest PHP with TestCase.php and helpers (A7, A27-A28)
4. **Story 1.4:** Configure PHPStan and PSR-12 code style (A29, A19)
5. **Story 1.5:** Implement Ollama CLI wrapper for LLM features (A4, A9)
6. **Story 1.6:** Create Onboarding Wizard for first-run experience (A17)
7. **Story 1.7:** Generate README.md with detailed sections (UX)

**Definition of Done (DoD):**
- [ ] All new tests pass 100% (A26)
- [ ] Code follows PSR-12 (enforced via php-cs)
- [ ] Static analysis passes (phpstan --level=8) (A29)
- [ ] Story referenced in commit message
- [ ] README.md has all sections (Installation, Quick Start, Commands, Troubleshooting)

---

### Epic 2: Pre-Migration Intelligence (Marco & Priya's Core Need) ✅ MVP

**User Value:** Marco and Priya can generate a Pre-Migration Intelligence Report that justifies the migration to executives.

**Stories:**
1. **Story 2.1:** Build AST Parser with parallel processing (A3, A8, NFR1-NFR2)
2. **Story 2.2:** Create cross-file symbol index (FR2)
3. **Story 2.3:** Implement confidence scoring engine (FR5, A25)
4. **Story 2.4:** Build blast radius calculator (FR6)
5. **Story 2.5:** Detect incompatible packages (FR8)
6. **Story 2.6:** Generate time/effort estimates (FR7)
7. **Story 2.7:** Output Pre-Migration Intelligence Report (FR9, FR1)
8. **Story 2.8:** Add LLM-powered plain-English explanations (A4, FR5)

**Definition of Done (DoD):**
- [ ] All new tests pass 100% (A26)
- [ ] Code follows PSR-12 (A19)
- [ ] Static analysis passes (A29)
- [ ] Pre-Migration Report outputs correctly with all sections
- [ ] LLM explanations are clear and actionable

---

### Epic 3: Migration Contract & Governance (Priya's Journey) ✅ MVP

**User Value:** Priya can define governance rules that control automation thresholds and protect critical files.

**Stories:**
1. **Story 3.1:** Parse Migration Contract YAML (FR14, A10)
2. **Story 3.2:** Scaffold default Migration Contract (FR13)
3. **Story 3.3:** Validate Migration Contract before apply (FR16)
4. **Story 3.4:** Implement threshold checking (auto-migrate vs manual review)
5. **Story 3.5:** Protect files/paths from automatic transformation (FR14)
6. **Story 3.6:** Enforce contract violations and halt migration (FR27)

**Definition of Done (DoD):**
- [ ] All new tests pass 100% (A26)
- [ ] Code follows PSR-12 (A19)
- [ ] Static analysis passes (A29)
- [ ] Migration Contract YAML parses correctly
- [ ] Threshold checking works correctly (auto-migrate < 85, manual ≥ 60)

---

### Epic 4: Phase A - Lumen 8 → Laravel 8 Migration (Core Transformation) ✅ MVP

**User Value:** Marco can migrate Lumen 8 apps to Laravel 8 with confidence-scored, reviewable changes.

**Stories:**
1. **Story 4.1:** Build composable rule registry (FR24, A13)
2. **Story 4.2:** Implement Lumen 8 → Laravel 8 rule set (FR24)
   - **4.2.1:** Bootstrap.php transformation (Lumen → Laravel)
   - **4.2.2:** Middleware registration transformation
   - **4.2.3:** Routing conversion (Lumen style → Laravel Route::)
   - **4.2.4:** Config file extraction (Lumen configure() → Laravel config/)
   - **4.2.5:** Eloquent factories handling (install legacy-factories if needed)
3. **Story 4.3:** Generate dry-run diff with confidence scores (FR10-FR12)
4. **Story 4.4:** Execute Phase A with snapshot creation (FR17-FR18)
5. **Story 4.5:** Handle idempotent/resumable apply (FR21, NFR10)
6. **Story 4.6:** Detect manually modified files (FR26)
7. **Story 4.7:** Run smoke test after Phase A (FR34)

**Definition of Done (DoD):**
- [ ] All new tests pass 100% (A26)
- [ ] Code follows PSR-12 (A19)
- [ ] Static analysis passes (A29)
- [ ] All 5 rule types (4.2.1-4.2.5) implemented and tested
- [ ] Dry-run diff shows confidence scores correctly
- [ ] Snapshot creates successfully before apply

---

### Epic 5: Phase B - Laravel 8 → 13 Upgrade (Rector Wrapper) ✅ MVP

**User Value:** Marco can complete the migration to Laravel 13 with Rector, safely audited for custom code.

**Stories:**
1. **Story 5.1:** Integrate Rector with version pinning (FR25, NFR16)
2. **Story 5.2:** Build custom audit layer for Rector changes (FR25, NFR5)
3. **Story 5.3:** Detect custom code proximity to Rector transformations (FR25)
4. **Story 5.4:** Execute Phase B with gate check (FR22-FR23)
5. **Story 5.5:** Handle Rector failures and partial application (NFR12)

**Definition of Done (DoD):**
- [ ] All new tests pass 100% (A26)
- [ ] Code follows PSR-12 (A19)
- [ ] Static analysis passes (A29)
- [ ] Rector version pinned in composer.json
- [ ] Audit layer flags all custom code proximity changes
- [ ] Phase B only executes after Phase A validated

---

### Epic 6: Validation & Quality Gates (Marco's Safety Net) ✅ MVP

**User Value:** Marco can trust that migrations won't break anything, with automatic validation and rollback.

**Stories:**
1. **Story 6.1:** Validate git repository exists (FR32)
2. **Story 6.2:** Check for dirty working directory (FR33)
3. **Story 6.3:** Execute post_phase_command and halt on failure (FR28-FR31)
4. **Story 6.4:** Create and manage rollback snapshots (FR18-FR20, NFR13)
5. **Story 6.5:** Detect and warn about missing/stale vendor/ (FR49)
6. **Story 6.6:** Verify cross-platform path handling (FR48)

**Definition of Done (DoD):**
- [ ] All new tests pass 100% (A26)
- [ ] Code follows PSR-12 (A19)
- [ ] Static analysis passes (A29)
- [ ] Git validation works on Windows/macOS/Linux
- [ ] Rollback restores exact pre-apply state
- [ ] post_phase_command failure halts migration correctly

---

### Epic 7: Knowledge Capture & Pattern Resolution (Learning System) ⚠️ Beta

**User Value:** Marco's resolved patterns become reusable rules, making each subsequent app migration faster.

**Stories:**
1. **Story 7.1:** Store resolved patterns in knowledge base (FR37)
2. **Story 7.2:** Prompt to generalise resolved patterns (FR35)
3. **Story 7.3:** Confirm/reject generalisation before applying (FR36)
4. **Story 7.4:** View accumulated knowledge base (FR38)
5. **Story 7.5:** Cross-app knowledge propagation (Beta)

**Definition of Done (DoD):**
- [ ] All new tests pass 100% (A26)
- [ ] Code follows PSR-12 (A19)
- [ ] Static analysis passes (A29)
- [ ] Knowledge base stores patterns in JSON format
- [ ] Generalisation prompt appears after human resolution

---

### Epic 8: Audit Trail & Compliance (Priya's Governance) ✅ MVP

**User Value:** Priya can export a complete audit trail for compliance sign-off.

**Stories:**
1. **Story 8.1:** Record transformation decisions to audit trail (FR39, A25)
2. **Story 8.2:** Record human approvals/rejections (FR40)
3. **Story 8.3:** Export full audit trail (FR41)
4. **Story 8.4:** Ensure .env never read/logged (FR42, NFR7)
5. **Story 8.5:** Implement append-only audit trail (NFR8)
6. **Story 8.6:** Collect success metrics for reporting (A30)

**Definition of Done (DoD):**
- [ ] All new tests pass 100% (A26)
- [ ] Code follows PSR-12 (enforced via php-cs)
- [ ] Static analysis passes (phpstan --level=8) (A29)
- [ ] Audit trail is append-only (NFR8)
- [ ] Export format is valid JSONL (FR41)
- [ ] Metrics collection works (FR28, FR31)

**Additional Stories for Epic 8 (Success Metrics):**
7. **Story 8.7:** Implement metrics collection (FR28, FR31, A30)
   - 8.7.1: Record migration start/complete events
   - 8.7.2: Record rule applications with confidence scores
   - 8.7.3: Record human interventions with rationale
   - 8.7.4: Export metrics for compliance report (Priya's CTO report)
8. **Story 8.8:** Export progress report for executives (John's #2)
   - 8.8.1: `larapgrader report progress --domain` (Alpha: --domain-simple)
   - 8.8.2: Output format: app status, % complete, time elapsed
   - 8.8.3: Generate summary: "Migration 60% complete, 3 apps done, 1 in progress"

---

### Epic 9: CLI Interface & Developer Experience (Marco's Daily Driver) ✅ MVP

**User Value:** Marco has a polished CLI tool with clear output, progress reporting, and helpful error messages.

**Stories:**
1. **Story 9.1:** Implement `analyse` command (FR43, FR1-FR9)
   - 9.1.1: Command structure with InputInterface/OutputInterface
   - 9.1.2: Integrate AST Parser + Confidence Scorer
   - 9.1.3: Output Pre-Migration Intelligence Report
   - 9.1.4: Add `--domain-simple` flag (Alpha aggregate report)
2. **Story 9.2:** Implement `migrate` command (plan + apply) (FR10-FR27)
   - 9.2.1: `migrate plan` with dry-run diff output
   - 9.2.2: `migrate apply` with snapshot creation
   - 9.2.3: Handle Phase A → Phase B gate checking
   - 9.2.4: Integrate rollback and state registry
3. **Story 9.3:** Implement `knowledge` command (FR35-FR38)
   - 9.3.1: `knowledge show` - view accumulated knowledge base
   - 9.3.2: Prompt to generalise resolved patterns
   - 9.3.3: Confirm/reject generalisation before applying
4. **Story 9.4:** Implement `report` command (FR39-FR42)
   - 9.4.1: `report export` - export audit trail (JSONL)
   - 9.4.2: `report progress --domain` - migration progress (Priya's view)
   - 9.4.3: Add `--format=json` flag (Beta)
5. **Story 9.5:** Implement `contract` command (FR13-FR16)
   - 9.5.1: `contract init` - scaffold Migration Contract
   - 9.5.2: Validate contract before apply
   - 9.5.3: Check thresholds and protected paths
6. **Story 9.6:** Add comprehensive --help output (FR43)
   - 9.6.1: Description, flags, example invocations
   - 9.6.2: Exit codes documentation (0, 1, 2, 3)
7. **Story 9.7:** Implement exit codes (FR44)
   - 7.1: Return named constants (not magic numbers)
   - 7.2: Map exit codes to meaningful messages
8. **Story 9.8:** Support --no-ansi, --verbose, --quiet flags (FR45-FR46)
   - 8.1: Detect terminal capabilities
   - 8.2: Stream progress for operations >60s (NFR3)
9. **Story 9.9:** Read tool config from larapgrader.yaml (FR47)
   - 9.1: Parse YAML config with symfony/yaml
   - 9.2: Validate config schema version
10. **Story 9.10:** Handle cross-platform path operations (FR48, NFR14)
    - 10.1: Windows/macOS/Linux path handling
    - 10.2: Detect and warn about missing/stale vendor/ (FR49)
11. **Story 9.11:** Create onboarding wizard for first-run experience (moved from Epic 1)
    - 11.1: Detect first run (no larapgrader.yaml)
    - 11.2: Interactive prompts for app path, LLM setup
    - 11.3: Generate larapgrader.yaml with sensible defaults

**Definition of Done (DoD):**
- [ ] All new tests pass 100% (A26)
- [ ] Code follows PSR-12 (A19)
- [ ] Static analysis passes (A29)
- [ ] All 5 commands work correctly with --help
- [ ] Exit codes return correctly (0, 1, 2, 3)
- [ ] Progress bar shows for operations >60s (NFR3)
- [ ] Onboarding wizard guides first-run experience ✅

---

### Epic 10: Domain-Aware Orchestration (Priya's Enterprise Feature) ⚠️ Beta

**User Value:** Priya can see cross-app dependencies and optimal migration sequencing for the entire domain.

**Stories:**
1. **Story 10.1:** Parse domain.json configuration (A18)
2. **Story 10.2:** Calculate migration order based on dependencies
3. **Story 10.3:** Generate basic aggregate report (--domain-simple, Alpha)
4. **Story 10.4:** Generate full aggregate report with sequencing (--domain, Beta)
5. **Story 10.5:** Map blast radius across app boundaries (FR6)

**Definition of Done (DoD):**
- [ ] All new tests pass 100% (A26)
- [ ] Code follows PSR-12 (A19)
- [ ] Static analysis passes (A29)
- [ ] domain.json parses correctly
- [ ] Migration order respects dependencies
- [ ] Basic aggregate report works for Alpha (--domain-simple)

---

## Requirements Coverage Validation ✅

**Functional Requirements Coverage:**
- FR Area 1 (9 FRs): Covered in Epic 2 ✅
- FR Area 2 (7 FRs): Covered in Epic 3 + Epic 4 ✅
- FR Area 3 (11 FRs): Covered in Epic 4 + Epic 5 ✅
- FR Area 4 (7 FRs): Covered in Epic 6 ✅
- FR Area 5 (4 FRs): Covered in Epic 7 ✅
- FR Area 6 (4 FRs): Covered in Epic 8 ✅
- FR Area 7 (7 FRs): Covered in Epic 9 ✅

**Non-Functional Requirements Coverage:**
- Performance (4 NFRs): Covered in Epic 2, Epic 9 ✅
- Security (5 NFRs): Covered in Epic 5, Epic 8 ✅
- Reliability (4 NFRs): Covered in Epic 4, Epic 6 ✅
- Integration (4 NFRs): Covered in Epic 6, Epic 9 ✅
- Scale (3 NFRs): Covered in Epic 2, Epic 9 ✅

**Additional Architecture Requirements Coverage:**
- Tech Stack (10 A): Covered in Epic 1 ✅
- Structure (8 A): Covered in Epic 1 ✅
- Patterns (7 A): Covered in all Epics ✅
- Quality (5 A): Covered in Epic 1, Epic 8 ✅

**Total Coverage: 49 FRs + 20 NFRs + 30 A = 99 Requirements ✅**

---

## Next Steps

1. **Review this epics document** - Verify all requirements are captured
2. **Prioritize epics for MVP** - Which epics deliver the most value first?
3. **Break stories into tasks** - Each story needs acceptance criteria
4. **Start with Epic 1** - Infrastructure must be built first
5. **Use bmad-dev-story skill** - Generate detailed story files for implementation

---

**What would you like to do?**

**[A]** Advanced Elicitation - Explore epic prioritization or story breakdown

**[P]** Party Mode - Review epics from multiple perspectives (Winston, Amelia, John)

**[C]** Continue - Save epics and move to story generation (Step 2)
