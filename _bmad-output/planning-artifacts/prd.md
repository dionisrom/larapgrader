---
stepsCompleted: [step-01-init, step-02-discovery, step-02b-vision, step-02c-executive-summary, step-03-success, step-04-journeys, step-05-domain, step-06-innovation, step-07-project-type, step-08-scoping, step-09-functional, step-10-nonfunctional, step-11-polish]
inputDocuments: ['_bmad-output/brainstorming/brainstorming-session-2026-04-15-1200.md']
workflowType: 'prd'
briefCount: 0
researchCount: 0
brainstormingCount: 1
projectDocsCount: 0
classification:
  projectType: developer_tool
  domain: enterprise_devtools
  complexity: high
  projectContext: greenfield
  mvp: cli_tool
  fullVersion: developer_platform
  adoptionModel: bottom_up_staged
  buyerJourney: engineers_first_then_org
  dashboardStatus: nice_to_have_next_iteration
  airGappedSupport: not_required_approved_ai_tool_in_use
  stateRegistryFormat: json_files
  upgradeTriger: cli_proves_value_then_org_buys_platform
---

## PRD Update Notes (2026-05-02)

Based on user feedback and critique review, the following updates were made:

1. **PHP Version Clarification:** All Lumen 8 apps already run on PHP 8.3 — no PHP upgrade needed during migration
2. **Laravel 13 Verified:** Released March 17, 2026 — requires PHP 8.3 (already satisfied)
3. **Confidence Scoring Algorithm:** Added weighted additive model with AST complexity + LLM explanations
4. **State Registry & Knowledge Base:** Specified JSON format, location (`.larapgrader/`), and schema
5. **Testing Framework:** Changed to **Pest PHP** for all tool tests
6. **Parallel Processing:** Added `symfony/process` + `amphp/parallel` for parallel file analysis
7. **Lumen→Laravel Transformations:** Added Phase A rule table (bootstrap, middleware, routing, etc.)
8. **Composer.json Handling:** Added transformation rules for `composer.json` updates
9. **Pre-Flight Checks:** Added dirty working directory check, smoke test, git validation
10. **Disaster Recovery:** Added recovery procedures beyond rollback
11. **Competitive Positioning:** Clarified this is NOT a Shift competitor — custom internal tool
12. **Domain Model:** Added `--domain-simple` flag for Alpha; full `--domain` in Beta
13. **Tech Stack Table:** Added comprehensive tech stack summary
14. **Resolved Open Questions:** PHP upgrade, confidence algorithm, state format, testing, parallel processing

---

# Product Requirements Document - larapgrader

**Author:** Boggie
**Date:** 2026-04-16

---

## Executive Summary

**larapgrader** is a self-hosted, domain-aware migration orchestrator that enables enterprise engineering teams to execute Lumen 8 → Laravel 13 migrations with measurable confidence, explicit governance, and a complete audit trail. It targets organisations running multiple Lumen 8 PHP services as an interconnected domain — Gateway APIs, CMS backends, Delivery APIs, and supporting services — where the interdependency, custom code, and unknown scope have made migration too risky to justify.

The primary obstacle to migration is not technical impossibility — it is the inability to answer *"how long, how risky, and what breaks?"* with enough precision to secure executive approval. Without that answer, migrations are deferred indefinitely while security debt accumulates on an abandoned framework. Lumen 8's abandonment means no CVE patches, no incremental security updates, and no path to a quick `13.x → 13.y` fix — every month of deferral compounds the organisation's exposure.

**larapgrader** resolves this by producing a **Pre-Migration Intelligence Report** before a single file is modified: estimated migration time, objective confidence scores calibrated to actual analysis findings, full blast radius maps across custom dependencies, and per-app layer breakdowns. This report is the business case. It is what walks into the exec meeting and unlocks the budget.

Migration then proceeds via a two-phase, layer-by-layer execution model: Phase A converts Lumen 8 to Laravel 8 (the framework switch — the hard, unique problem); Phase B orchestrates the Laravel 8 → 13 version upgrade using Rector. Both phases are covered by the same confidence scoring and review gates — Rector transformations that touch code near custom classes or methods are flagged for human review via the Phase A symbol index. Rector handles the standard path; larapgrader audits the non-standard one. All transformations are governed by a versioned, team-authored Migration Contract that sets automation thresholds, protected files, and approval gates. Every decision — automated or human — is logged in a full audit trail.

**Target users (staged adoption):**
- **Engineers** (primary adopters) — run `migrate plan` and `migrate apply`, resolve flagged patterns, own the migration day-to-day
- **Tech leads** — author the Migration Contract, approve plans, sign off on low-confidence items, own the governance layer
- **Platform/DevOps teams** — integrate the tool into CI/CD pipelines via baseline mode and structured output

### What Makes This Special

No existing tool addresses the Lumen 8 → Laravel framework switch specifically. Laravel Shift is cloud-hosted (code leaves the organisation), single-app scoped, and has no custom code handling. Rector has no Lumen bootstrap awareness and covers PHP version upgrades, not framework switching. Neither produces a business case or understands inter-service dependencies.

**larapgrader's differentiators:**
- **Pre-Migration Intelligence Report** — produces a scoped, time-estimated, confidence-scored business case before any code changes
- **Domain-aware orchestration** — understands inter-service contracts, proposes migration sequencing to prevent integration boundary breakage, aggregates confidence insights cross-app
- **Configurable governance** — the Migration Contract puts the tech lead in control of automation thresholds, protected files, and approval gates; committed to the repo as a versioned, auditable artifact
- **Rector safety wrapper** — Phase B Rector transformations are audited against the symbol index; custom code adjacent to framework API changes is flagged, not silently transformed
- **Self-hosted, privacy by design** — code never leaves the organisation's infrastructure; no cloud dependency
- **Knowledge capture** — human-resolved migration patterns become reusable rules, making each subsequent app migration faster and smarter than the last

**Core insight:** The migration tool that enterprises actually need isn't a code transformer — it's a confidence engine that makes a previously unjustifiable project justifiable.

### Project Classification

| Field | Value |
|---|---|
| Project Type | Developer Tool — CLI (MVP), Developer Platform (full version) |
| Domain | Enterprise DevTools |
| Complexity | High |
| Project Context | Greenfield |
| Adoption Model | Bottom-up staged — engineers adopt, org buys in |
| Deployment | Self-hosted only |
| PHP Target | PHP 8.3 |
| Framework Path | Lumen 8 → Laravel 8 (Phase A) → Laravel 13 (Phase B) |

### PHP Version Note

All target Lumen 8 applications are already running on PHP 8.3, so no PHP version upgrade is required as part of the migration. Laravel 13 (released March 17, 2026) requires PHP 8.3 minimum, which is already satisfied.

---

## Success Criteria

### User Success

- **Primary success gate:** All external test suite commands (configured via `post_phase_command`) exit green after each migration phase. This is the non-negotiable definition of a successful migration hop.
- **Secondary success gate:** All tool-generated tests (Swagger contract tests + route introspection tests) pass post-migration.
- **Engineer confidence:** The engineer running the migration can explain every flagged item and every human decision made — the audit trail and dry-run report are sufficient to reconstruct the full migration rationale.
- **Tech lead confidence:** The Pre-Migration Intelligence Report accurately predicted the migration scope — estimated layer count, flagged item count, and time estimate were within acceptable variance of actuals.

### Business Success

- **Domain migration complete:** All apps in the service domain (Gateway API, CMS BE, Delivery API, and supporting services) migrated successfully to Laravel 13 within the agreed target timeframe.
- **Time-to-justify:** The Pre-Migration Intelligence Report is sufficient to secure executive approval without additional manual discovery work — the report itself becomes the business case.
- **Security posture restored:** All apps are on a maintained Laravel version capable of receiving incremental security patches (`13.x → 13.y`) without custom framework work.
- **Zero silent regressions:** No post-migration production incidents caused by changes the tool made without flagging.

### Technical Success

- **Phase gate integrity:** Phase B does not execute unless Phase A's post-phase test command exits green.
- **Rector audit coverage:** 100% of Rector-transformed files that touch custom class/method boundaries are flagged for human review — no silent transformations of custom code.
- **Confidence score calibration:** After the first app migration, estimated confidence scores correlate with actual human intervention required (calibration baseline established).
- **State registry integrity:** Running `migrate apply` twice on the same codebase is idempotent — already-applied rules are skipped, no duplicate transformations.
- **Rollback reliability:** Any named snapshot can be restored in a single command with no data loss.

### Measurable Outcomes

| Outcome | Target |
|---|---|
| External test suite pass rate post-migration | 100% (all green) |
| Domain apps migrated | 100% within agreed timeframe |
| Silent custom-code transformations | 0 |
| Pre-Migration Report accuracy (scope estimate vs. actuals) | Within 20% variance |
| Rollback success rate | 100% |
| Audit trail completeness | Every decision logged with before/after diff |

---

## Project Scoping & Phased Development

### MVP Strategy & Philosophy

**MVP Approach:** Problem-solving MVP — the tool must demonstrably solve the migration confidence problem for one domain run (4 apps, 2 engineers, 8 weeks) before any broader investment. Success = all four apps on Laravel 13, Python tests green, audit trail exportable, zero production incidents attributable to tool error.

**Target user for Alpha:** The internal engineering team — 2 engineers who know the codebase. No onboarding UX, no generic examples, no polish. The goal is a working, trustworthy migration for this specific domain.

**Resource Requirements:** 1–2 engineers building and using the tool simultaneously. No dedicated QA, no DevOps overhead beyond local dev environment.

### Phase 1 — Alpha MVP (CLI, Internal)

**Core journeys supported:** Marco (engineer running migration) + Priya (tech lead governing migration)

**Must-have capabilities:**

| Capability | Rationale |
|---|---|
| `larapgrader analyse` + Pre-Migration Intelligence Report | Without this, no executive approval, no migration starts |
| Phase A engine: Lumen 8 → Laravel 8 (nikic/php-parser, composable rule registry) | Core transformation — without this, the tool does nothing |
| Confidence scoring with plain-English explanations | Engineers cannot make informed decisions without knowing *why* something is flagged |
| Dry-run diff report (`migrate plan`) | No one applies blindly — this is non-negotiable |
| `migrate apply` with automatic snapshot before execution | Safety net — engineers won't use it without rollback |
| Configurable Migration Contract (YAML, versioned) | Governance layer — required for Priya's journey |
| External test suite hook (`post_phase_command`) | Python test suite is the ground truth — no gate = no trust |
| Phase B engine: Laravel 8 → 13 via Rector + custom-code audit wrapper | Complete the migration — both phases required for a useful Alpha |
| Full audit trail + export | Compliance sign-off required at end of project |
| Blast radius map | Engineers need to understand impact before proceeding |
| State registry (idempotent, resumable) | Multi-session migration over 8 weeks requires resumability |
| Domain-ready data model | Hard architectural constraint — Alpha must not require rework for Beta; simplified `--domain` aggregate view available via `--domain-simple` flag in Alpha |
| Self-hosted, zero outbound calls from AST core | Privacy requirement — non-negotiable |
| Windows + macOS + Linux support | Engineers run Windows/macOS locally |

**Deliberately excluded from Alpha:**

| Excluded | Reason |
|---|---|
| `analyse --domain` aggregate report | Single-app analyse sufficient for Alpha; domain view is Beta |
| Knowledge base cross-app propagation | Alpha uses one domain sequentially — manual pattern propagation acceptable |
| LLM-assisted rule authoring | Rule set is authored before Alpha; LLM mode is a developer productivity tool for Beta |
| Static test suite generator | Valuable but not on the critical path to migration completion |
| Dashboard / web UI | All information available via CLI output for Alpha |
| CI/CD delta gate | Target is migration completion, not ongoing CI integration |
| Hybrid LLM engine (below-threshold AI resolution) | Confidence scoring alone is sufficient for Alpha; LLM enhancement is Beta |

### Phase 2 — Beta (Post-MVP, Team + External Early Adopters)

- `analyse --domain`: cross-app aggregate report with migration sequencing
- Knowledge base cross-app propagation (resolved patterns available across domain)
- LLM-assisted rule authoring mode (approved AI tool integration)
- Hybrid LLM engine for below-threshold ambiguous pattern resolution
- Static test suite generator (Swagger contract tests + route introspection)
- Persistent pattern learning (fine-tunes on team's resolved cases)
- Contract boundary detector (inter-service DTOs, event payloads, API shapes)
- CI/CD readiness gate (migration cost delta per PR)
- Migration rule versioning (flag files migrated with older rule versions)
- Migration Progress Dashboard (local web UI / TUI — evaluate demand)
- External distribution: Composer global + PHAR binary

### Phase 3 — Vision (Platform / Ecosystem)

- Advisor Mode (pure intelligence layer, no code transformation — zero-risk entry for risk-averse orgs)
- Developer Platform: rich UI, visual migration topology, IDE plugin
- Pluggable rule engine + community ecosystem (third-party rule packs)
- Multi-domain portfolio support (multiple unrelated domains in one tool instance)

### Pre-Flight Checks (Before Any Migration)

Before executing `migrate apply`, the system must run these checks:

1. **Git Repository Check:** Verify `.git/` exists and is accessible (FR32)
2. **Dirty Working Directory Check:** Run `git status --porcelain` — if output is non-empty, halt and offer to `git stash` or abort (FR33)
3. **PHP Version Verification:** Confirm PHP 8.3+ is running (even though target apps are already on 8.3, verify tool compatibility)
4. **Vendor Directory Check:** Verify `vendor/` exists and is not stale (FR49)
5. **Composer.json Validity:** Parse `composer.json` to ensure it's valid JSON and has required keys
6. **Migration Contract Check:** Verify `MigrationContract.yaml` exists and is valid YAML (FR16)
7. **Smoke Test (Optional):** After Phase A, run `php artisan --version` to verify Laravel boots correctly (FR34)

---

### Risk Mitigation Strategy

**Technical risks:**
- *Biggest risk:* Phase A rule completeness — the Lumen 8 → Laravel 8 rule set must cover the actual patterns in this specific codebase. Mitigation: run `analyse` early; use confidence scoring to surface gaps before `apply`. Unknown patterns = low confidence = human review, not silent failure.
- *Second risk:* Rector audit wrapper false negatives in Phase B. Mitigation: all Rector changes touching custom symbol boundaries are flagged regardless of confidence score — no silent pass.
- *Third risk:* Dirty working directory causes conflicts during migration. Mitigation: Pre-flight check (FR33) halts and offers `git stash` before `migrate apply`.
- *Fourth risk:* Application doesn't boot after Phase A. Mitigation: Optional smoke test (FR34) runs `php artisan --version` to verify Laravel boots correctly.

**Market/adoption risks:**
- *Risk:* Tool is useful but too slow to author rules for a new codebase (adoption beyond internal team). Mitigation: Alpha validates the core engine; LLM-assisted rule authoring (Beta) directly addresses this. Rule set is open and composable by design.
- *Clarification:* This tool is **NOT** a Shift competitor — it's a custom internal tool for migrating *this organisation's* Lumen 8 apps to Laravel 13.

**Resource risks:**
- *Risk:* 2 engineers building and migrating simultaneously creates context switching. Mitigation: Alpha scope is deliberately tight — Phase A rule set + core CLI commands. Beta features only start after Alpha migration run is complete.
- *Risk:* Performance issues with large codebases. Mitigation: Parallel processing via `symfony/process` + `amphp/parallel` (default 10 files/batch) to meet NFR1 (5 min/100k lines).

---

## User Journeys

### Journey 1: Marco — The PHP Engineer Running the Migration

**Opening Scene:** Marco's team has been told the Lumen migration is finally approved — Q3 deliverable. He opens the repo for the first time in weeks and stares at the codebase. Four services. Multiple dev hands over four years. Zero documentation on the custom auth guard. He doesn't know where to start.

**Rising Action:** Marco runs `larapgrader analyse`. Within minutes the Pre-Migration Intelligence Report is generated. He can see: 4 apps, 6–8 layers each, 34 auto-migratable patterns, 8 requiring human review, 3 custom packages flagged as incompatible, estimated 7–10 weeks at 2 engineers. The blast radius map shows the custom auth guard touches 23 files across 2 apps.

He runs `migrate plan --app=gateway-api --phase=A`. The dry-run diff appears: every proposed change, file by file, with confidence scores. He sees 4 items below the auto-migrate threshold — the tool explains *why* for each one in plain English. He reviews the diff, approves the contract, runs `migrate apply`. The tool creates a snapshot automatically before proceeding.

**Climax:** Phase A completes. The tool runs `pytest tests/ -x`. 847 tests. 846 pass. 1 fails. The tool halts, shows exactly which file was touched, shows the diff. Marco resolves it manually in 20 minutes. He marks the pattern as resolved. The tool asks: *"Apply this resolution to 3 similar cases in the same app?"* He confirms. All 4 issues closed. `pytest` green. Phase B unlocked.

**Resolution:** Eight weeks later, all four apps are on Laravel 13. Every decision is in the audit trail. Marco's team had no production incidents. The knowledge base grew with each app — the fourth app migration took half the time of the first.

*Reveals requirements for:* analyse command, plan command, confidence scoring, dry-run diff, blast radius map, external test hook, rollback snapshots, knowledge capture, plain-English explanations of flagged items.

---

### Journey 2: Priya — The Tech Lead Governing the Migration

**Opening Scene:** Priya has been asked to present the migration plan to the CTO next week. She has two engineers available, three months, and a domain of four production services. She has no idea how to estimate this. Every attempt to research it ends with "it depends."

**Rising Action:** She runs `larapgrader analyse --domain`. The Pre-Migration Intelligence Report lands. She has numbers — real ones, derived from what's actually in the codebase, not guesses. She opens the Migration Contract template and configures the governance layer: auto-migrate threshold at 85, manual approval required for anything in `src/Auth/` and `src/Core/`, rollback snapshots before every layer.

She walks into the CTO meeting with the report. The migration is approved.

**Climax:** Three weeks in, an engineer hits a pattern in the Delivery API that falls below threshold. The tool halts. Priya reviews the flagged diff in the structured report output. She approves the proposed resolution with a comment. The audit trail logs her name, timestamp, and rationale.

**Resolution:** At project completion, Priya exports the full audit trail. Every automated decision, every human approval, every test run result — dated, attributed, with before/after diffs. The compliance report goes to the CTO. The migration is signed off.

*Reveals requirements for:* domain analyse, Migration Contract authoring, configurable thresholds, protected file/path config, structured human-readable report output, audit trail export, approval workflow.

---

### Journey 3: DevOps Team — One-Time Infrastructure Verification (Planning Note)

After each app migration is validated locally (Python tests green, tool-generated tests green), the DevOps team runs a one-time environment verification to confirm the deployment target is Laravel 13-ready (PHP extensions, env vars, queue drivers, infra config). This is not a feature the tool actively supports — but the migration report and audit trail provide the input the DevOps team needs to know what changed.

**Planning note for tech leads:** Schedule DevOps infrastructure verification time for each app after local migration sign-off. This is outside the tool's scope but on the critical path to production deployment.

---

### Journey Requirements Summary

| Capability | Revealed by |
|---|---|
| `larapgrader analyse` + `analyse --domain-simple` (Alpha) / `analyse --domain` (Beta) | Marco, Priya |
| Pre-Migration Intelligence Report | Marco, Priya |
| `migrate plan` + `migrate apply` | Marco |
| Dry-run diff report | Marco |
| Confidence scoring + plain-English flagged item explanations | Marco |
| Blast radius map with cascading chains | Marco, Priya |
| External test suite hook (`post_phase_command`) | Marco |
| On-demand + automatic rollback snapshots | Marco |
| Knowledge capture (pattern generalisation prompt) | Marco |
| Migration Contract authoring + threshold configuration | Priya |
| Protected file/path configuration | Priya |
| Audit trail + compliance export | Priya |
| Structured human-readable report output | Priya |
| Structured JSON/YAML CLI output mode | Beta — lower priority for current use case |

---

## Domain-Specific Requirements

### Privacy & Security Constraints

- **Self-hosted mandatory:** Code never leaves the organisation's infrastructure during migration execution. No telemetry, no cloud-based analysis, no external API calls during `analyse`, `plan`, or `apply` phases. This is a hard architectural constraint.
- **No secrets at risk:** `.env` and Docker config files do not contain secrets that could be leaked. However, the tool must not read or include `.env` file contents in any report, log, or AI prompt payload regardless — defence in depth.
- **Approved AI tool only:** The organisation has Enterprise access to an approved AI tool (e.g. GitHub Copilot Enterprise). Any LLM-assisted features (plain-English explanations, rule authoring mode, pattern suggestion) must route exclusively through this approved tool. No other external LLM endpoints.
- **Third-party exfiltration risk:** During a migration run, the tool itself must not initiate any outbound network calls except to the approved AI tool (when LLM features are explicitly invoked). All AST analysis, rule application, and state management must function fully offline. This must be architecturally verifiable — not a policy statement.
- **Local LLM fallback:** Local LLM support (e.g. Ollama) is a desirable option for engineers who prefer not to route code through any external service, or for environments where the approved AI tool is temporarily unavailable.

### Network & Dependency Constraints

- **Composer in restricted environments:** ⚠️ **Open question** — if the migration tool is run in a network-restricted environment (e.g. a dev container with limited outbound access), `composer install` / `composer update` on the target application may fail. The tool must either:
  - Document clearly that target app dependencies must be resolvable before migration begins, OR
  - Detect and warn when `vendor/` is missing or stale, rather than silently failing mid-migration.
  - This does not affect the tool's own dependencies, which are installed once during tool setup.
- **No runtime composer operations:** The tool must not run `composer install` or `composer update` on the target application as part of a migration step without explicit user consent. Dependency changes are a separate concern from code transformation.

### Technical Constraints

- **PHP 8.3 runtime:** The tool itself runs on PHP 8.3. No cross-runtime dependencies (Node, Python, etc.) required for core functionality.
- **nikic/php-parser compatibility:** Parser version must be pinned and tested against PHP 8.3 syntax features (readonly properties, enums, fibers, first-class callables, intersection types).
- **Rector version pinning:** Phase B Rector integration must pin to a specific Rector version to ensure reproducible transformations across engineers and CI runs.
- **State registry safety:** Multiple engineers may work against the same codebase. The state file must use an append-only, lockable structure to prevent corruption under concurrent access. Conflicts must be informative, not silently destructive.
- **Git-based rollback:** Snapshot strategy relies on git (branch or stash). Non-git repos are out of scope for MVP. The tool must detect a missing git context and halt with a clear error before any transformation begins.

### Risk Mitigations

| Risk | Mitigation |
|---|---|
| Tool makes outbound calls beyond approved AI tool | All network calls auditable; AST core has zero external dependencies; AI calls are explicit and logged |
| Rector silently transforms custom code | Phase B audit layer flags all Rector changes near custom symbols (#50) |
| Composer dependency resolution fails mid-migration | Tool validates `vendor/` presence before starting; warns and halts if stale |
| Multi-dev inconsistent patterns degrade confidence scoring | Confidence scoring degrades gracefully — unknown pattern = low score, not failure |
| State file corruption in team environment | Append-only, lockable state registry; git conflicts are informative not destructive |
| Phase B breaks what Phase A fixed | `post_phase_command` gates Phase B — Phase A must be green before Phase B runs |
| LLM feature unavailable (approved tool outage) | Local LLM fallback available; LLM features are enhancements, not blockers for core migration |

### Disaster Recovery (Beyond Rollback)

When standard rollback is insufficient:

1. **Partial Rule Application Failure:**
   - If a rule partially applies then fails mid-execution, the state registry records the failure point
   - Engineer can choose: (a) Rollback to pre-apply snapshot, or (b) Resume from last successful rule
   - Tool validates file integrity before resuming

2. **State Registry Corruption:**
   - Backup `state.json` before each write (kept as `state.json.backup`)
   - If corruption detected (invalid JSON, schema mismatch), restore from backup
   - If backup also corrupted, rebuild state from git history: `git diff --name-only <pre-migration-commit>..HEAD`

3. **Manual Changes Conflict with Pending Migrations:**
   - Before `migrate apply`, tool checks if files modified since last `migrate plan`
   - If conflicts detected, halt and warn: "File X was modified manually. Re-run `migrate plan` to update diff."
   - Engineer can force apply with `--force` flag (logged to audit trail)

4. **Engineer Makes Manual Fixes Post-Migration:**
   - Tool detects manual changes via git diff comparison
   - Prompts: "Detected manual changes to migrated files. Mark as resolved? [Y/n]"
   - If yes, updates knowledge base with manual fix as a new pattern resolution

---

### Open Questions — Resolved

| Question | Status | Resolution |
|---|---|---|
| PHP version upgrade path | ✅ Resolved | All Lumen 8 apps already on PHP 8.3; no PHP upgrade needed during migration |
| Confidence score algorithm | ✅ Resolved | Weighted additive model with AST complexity + LLM explanations (see Confidence Scoring section) |
| State registry & knowledge base format | ✅ Resolved | JSON files in `.larapgrader/` directory (see State Registry section) |
| Testing framework | ✅ Resolved | Pest PHP for all tool tests |
| Parallel processing | ✅ Resolved | `symfony/process` + `amphp/parallel`, 10 files/batch default |
| Competitive positioning | ✅ Resolved | NOT a Shift competitor — custom internal tool for specific organisation |
| Domain model for Alpha | ✅ Resolved | Simplified `--domain-simple` flag for Alpha; full `--domain` in Beta |

### Open Questions — Remaining

| Question | Status |
|---|---|
| Which approved Enterprise AI tool is in use (Copilot Enterprise, other)? | To confirm — affects API integration design |
| Composer resolution strategy for restricted environments | To decide before Beta |
| Local LLM fallback: Ollama specifically, or any OpenAI-compatible endpoint? | To decide during Alpha |
| Outbound network call audit: log only, or block by default with allowlist? | To decide — architecture decision |
| Smoke test command for Phase A verification | Default: `php artisan --version`; configurable via `larapgrader.yaml` |

| Question | Status |
|---|---|
| Which approved Enterprise AI tool is in use (Copilot Enterprise, other)? | To confirm — affects API integration design |
| Composer resolution strategy for restricted environments | To decide before Beta |
| Local LLM fallback: Ollama specifically, or any OpenAI-compatible endpoint? | To decide during Alpha |
| Outbound network call audit: log only, or block by default with allowlist? | To decide — architecture decision |

---

## Innovation & Novel Patterns

### Detected Innovation Areas

**1. The Confidence Engine Paradigm**
larapgrader reframes the migration tool category. Existing tools (Laravel Shift, Rector, Codemods) are *code transformers* — they take code in and emit modified code out. larapgrader is a *confidence engine* — it produces trust artefacts (Pre-Migration Intelligence Report, dry-run diff with scored explanations, audit trail) that govern organisational decision-making, not just code. The transformation is a side effect of building confidence. This is the primary innovation.

**2. Declarative Migration Governance (Migration Contract)**
The Migration Contract is a user-authored YAML/config file that defines what the tool is permitted to do automatically, what requires human approval, and what is protected from transformation. This is effectively a **declarative governance DSL** — expressing migration intent in a reviewable, versionable, team-shareable form. No existing migration tool exposes this abstraction. The closest analogy is a Terraform plan file — the migration won't proceed unless the contract is satisfied.

**3. Domain-Scoped Knowledge Loop**
The tool accumulates a knowledge base across apps within the same domain run. When a pattern is flagged, resolved, and generalised, that resolution is available for subsequent apps in the domain. This "gets smarter as it goes" characteristic — the 4th app migrates faster than the 1st — is novel for a code transformation tool and directly addresses the multi-service enterprise use case.

**4. Two-Phase Composable Architecture with Confidence Gate**
Phase A (Lumen 8 → Laravel 8, custom AST rule engine) and Phase B (Laravel 8 → 13, Rector with audit wrapper) are decoupled phases with an external test suite gate between them. Neither phase proceeds unless confidence gates are satisfied. This composable, gated approach is novel — it treats migration as an incremental, validated process rather than a single-pass transformation.

### Market Context & Competitive Landscape

**Important Note:** larapgrader is **NOT** a Laravel Shift competitor. Shift is a commercial SaaS product for general Laravel upgrades. larapgrader is a **custom enterprise tool** built specifically to migrate *this organisation's* Lumen 8 applications to Laravel 13, with domain-aware orchestration and governance tailored to internal requirements.

| Tool | What it does | Relationship to larapgrader |
|---|---|---|
| Laravel Shift | Automated Lumen/Laravel upgrades (SaaS) | Not a competitor — Shift is a general-purpose commercial service; larapgrader is a custom internal tool for a specific codebase |
| Rector | PHP AST transformation rules | Complementary — used in Phase B for Laravel 8→13 upgrades |
| PHPStan / Psalm | Static analysis, type checking | Complementary — could be integrated as a pre-flight check before migration |
| Custom migration scripts | One-off, team-specific | larapgrader replaces these with a reusable, governed, knowledge-capturing solution |

**The Problem Space:** Enterprise Lumen 8 applications with custom code, inter-service dependencies, and unknown migration scope that make manual migration too risky to justify. larapgrader solves *this specific problem* for *this specific organisation*.

**Why Not Just Use Shift?**
- Code leaves the organisation (SaaS) — violates self-hosted requirement
- Single-app scoped — doesn't understand inter-service domain dependencies
- No custom code handling — can't safely transform near custom business logic
- No governance layer — no Migration Contract, no audit trail, no confidence scoring
- No business case output — can't generate Pre-Migration Intelligence Report for exec approval

larapgrader is purpose-built for this organisation's Lumen 8 → Laravel 13 migration, with domain awareness, governance, and confidence scoring that general-purpose tools don't provide.

### Validation Approach

- **Pre-Migration Intelligence Report accuracy:** Does the tool's estimate (weeks, apps, flagged items) match actual migration outcomes? Track estimate vs actuals across the domain run.
- **Confidence score calibration:** Do items scored above the auto-migrate threshold actually migrate cleanly? Do items below threshold actually require human intervention? Build a calibration loop from knowledge base data.
- **Knowledge base leverage:** Does migration time decrease with each subsequent app in the domain? Measure time-per-app across the 4-app domain run.
- **Python test suite gate:** Does the external test hook reliably catch regressions introduced by the tool? Track halt events and false negatives.

### Risk Mitigation

| Innovation Risk | Mitigation |
|---|---|
| Migration Contract too complex → low adoption | Contract has sensible defaults; zero-config mode available for simple apps |
| Confidence scoring miscalibrated → false confidence | Scores are transparent with plain-English explanations; all below-threshold items require human review regardless |
| Knowledge base generalisation produces incorrect resolutions | All generalisations require explicit user confirmation before applying to additional cases |
| Two-phase gate too strict → blocks progress | Gate threshold configurable; manual override available with audit trail entry |

---

## Developer Tool — Specific Requirements

### Project-Type Overview

larapgrader is a PHP 8.3 CLI developer tool distributed via Composer. It is a self-hosted, single-domain migration orchestrator targeting internal engineering teams running Lumen 8 → Laravel 13 upgrades. For Alpha, distribution and documentation are deliberately minimal — the tool is used exclusively by the team that builds it, on their own codebase.

### Language Matrix

| Dimension | Decision |
|---|---|
| Tool runtime | PHP 8.3 |
| Target codebase language | PHP 8.3 (Lumen 8 source) |
| Multi-language support | Not in scope |
| OS support | Linux, macOS, **Windows** (dev environments); Linux (CI/production) |
| Windows support | ✅ Required for Alpha — engineers run Windows locally |

### Installation Methods

| Method | Alpha | Beta |
|---|---|---|
| `composer require --dev` (project-level) | ✅ Primary | ✅ |
| `composer global require` | Optional | ✅ |
| Docker image (portable, no PHP required on host) | ❌ | Consider |
| Binary distribution (Box/PHAR) | ❌ | Consider |

### Tech Stack Summary

| Component | Technology | Purpose |
|---|---|---|
| **Language** | PHP 8.3 | Tool runtime |
| **AST Parser** | `nikic/php-parser` | PHP code analysis |
| **Phase B Engine** | Rector (pinned version) | Laravel 8→13 transformations |
| **Testing** | Pest PHP | All tool tests |
| **Parallel Processing** | `symfony/process` + `amphp/parallel` | Parallel file analysis |
| **Git Integration** | `symfony/process` (git CLI) | Snapshots, rollback, dirty check |
| **CLI Framework** | Custom (PHP CLI) | Command parsing, output formatting |
| **Config Files** | YAML (`symfony/yaml`) | `larapgrader.yaml`, `MigrationContract.yaml` |
| **State Storage** | JSON files | `.larapgrader/state.json`, `knowledge-base.json` |
| **LLM Integration** | HTTP client (`guzzlehttp/guzzle`) | Approved AI tool API calls |
| **Windows Support** | Cross-platform PHP | Path handling, shell commands |

### API Surface (CLI Commands)

The public API of this tool is its CLI command surface. All commands follow `larapgrader <verb> [--options]` convention.

| Command | Phase | Description |
|---|---|---|
| `larapgrader analyse` | Pre-migration | Analyse a single app — generate Pre-Migration Intelligence Report |
| `larapgrader analyse --domain` | Pre-migration | Analyse all apps in domain — aggregate report |
| `larapgrader migrate plan` | Phase A or B | Generate dry-run diff + Migration Contract scaffold |
| `larapgrader migrate apply` | Phase A or B | Execute approved plan, create snapshot, run `post_phase_command` |
| `larapgrader migrate rollback` | Recovery | Restore from snapshot |
| `larapgrader knowledge show` | Governance | Display accumulated knowledge base for domain |
| `larapgrader report export` | Governance | Export audit trail in structured format |
| `larapgrader contract init` | Governance | Scaffold a Migration Contract config file |

### Documentation

**Alpha:** Inline `--help` output per command + `README.md`. No hosted docs site.

`--help` must be comprehensive — it is the primary onboarding surface for Alpha engineers. Each command's help output must include: description, required/optional flags, example invocations, exit codes.

**Beta:** Evaluate hosted docs (MkDocs or similar) if the tool is shared beyond the internal team.

### Code Examples

**Alpha:** No standalone example apps. Internal team uses their own codebase as the reference.

Engineers will run `larapgrader contract init` to scaffold their first Migration Contract — that scaffold is the primary "example" and must be well-commented inline.

**Beta:** Consider a `larapgrader/example-domain` repo with a dummy Lumen 8 codebase for external onboarding.

### Migration Guide (Tool Upgrades)

The tool itself will need an upgrade path as rule sets are updated. For Alpha:
- Rule set versioning must be explicit (rule set version pinned in Migration Contract)
- Tool upgrades that change rule behaviour must produce a changelog entry indicating which patterns are affected
- Engineers must be able to re-run `analyse` after a tool upgrade to see if the report changes

### Implementation Considerations

- **Exit codes:** All commands must return meaningful exit codes (0 = success, 1 = halted by confidence gate, 2 = error, 3 = human review required). Scripting and CI integration depend on this.
- **Output modes:** Default = human-readable terminal output with colour. `--no-ansi` flag for CI/logging environments. `--json` flag for machine-readable output (Beta).
- **Configuration file:** `larapgrader.yaml` at project root — tool config (thresholds, AI endpoint, `post_phase_command`, etc.) separate from Migration Contract.
- **Verbosity:** `--verbose` / `--quiet` flags standard across all commands.
- **Windows compatibility:** All file path handling must use cross-platform path resolution. Shell commands in `post_phase_command` must be documented as platform-specific (e.g. `pytest` on Windows vs Linux). Git operations must use PHP git library or `proc_open` with cross-platform awareness.
- **Testing framework:** Use **Pest** (PHP testing framework) for all tool tests. Pest's expressive syntax and built-in mocking simplify test authoring for the rule engine, AST analysis, and CLI commands.
- **Parallel processing:** Use `symfony/process` with `amp/reactphp` for parallel AST analysis when scanning large codebases. Process files in parallel batches (configurable batch size, default 10 files/process) to meet NFR1 (5 min for 100k lines).

---

## Functional Requirements

### FR Area 1 — Pre-Migration Analysis

- **FR1:** An engineer can run an analysis of a single application to generate a Pre-Migration Intelligence Report
- **FR2:** The system can perform a pre-analysis indexing pass across the entire codebase, building a cross-file symbol index (class hierarchy, trait usage, interface implementations, service bindings, custom facades, middleware chains) before any rule is applied
- **FR3:** The system can parse and traverse a Lumen 8 PHP codebase using AST analysis to identify all migration-relevant patterns, using the cross-file symbol index for accurate cross-boundary reasoning
- **FR4:** The system can classify each discovered pattern as auto-migratable, requires-human-review, or incompatible
- **FR5:** The system can calculate a confidence score for each discovered pattern and present it with a plain-English explanation of the scoring rationale
- **FR6:** The system can generate a blast radius map showing which files and layers are affected by each flagged pattern, including cascading dependency chains
- **FR7:** The system can produce a time and effort estimate (weeks, engineer count, pattern counts by classification) from analysis results
- **FR8:** The system can detect and report custom packages or dependencies that are incompatible with Laravel 8 or Laravel 13
- **FR9:** The system can output the Pre-Migration Intelligence Report in a human-readable format suitable for executive presentation

### FR Area 2 — Migration Planning & Dry-Run

- **FR10:** An engineer can generate a migration plan (dry-run diff) for a specific application and phase without modifying any files
- **FR11:** The system can present every proposed code change, file by file, with confidence scores, before any transformation is applied
- **FR12:** An engineer can review all items flagged below the auto-migrate threshold before proceeding to apply
- **FR13:** The system can scaffold a Migration Contract configuration file with sensible defaults for the target application
- **FR14:** A tech lead can author a Migration Contract that specifies: auto-migrate confidence threshold, files/paths protected from automatic transformation, and required human approval checkpoints
- **FR15:** The Migration Contract must be a versionable YAML file committable to the application repository
- **FR16:** The system must refuse to proceed to `apply` if no Migration Contract exists or if the contract has not been reviewed

### FR Area 3 — Migration Execution

- **FR17:** An engineer can execute a migration plan against a target application, applying only the transformations approved in the dry-run diff
- **FR18:** The system must automatically create a labelled rollback snapshot before executing any apply operation
- **FR19:** An engineer can view the full snapshot registry with human-readable labels and timestamps for all snapshots associated with the current application
- **FR20:** An engineer can manually trigger a rollback to restore the application to any named snapshot state
- **FR21:** The system must execute migrations in a resumable, idempotent manner — a failed or interrupted apply can be safely re-run
- **FR22:** The system must execute Phase A (Lumen 8 → Laravel 8) and Phase B (Laravel 8 → 13) as discrete, independently confirmable steps
- **FR23:** The system must prevent Phase B from executing until Phase A has been applied and validated
- **FR24:** The system can apply Phase A transformations using a composable, versioned rule registry built on AST pattern matching
- **FR25:** The system can apply Phase B transformations via a Rector integration with a custom audit layer that flags all changes touching custom symbol boundaries
- **FR26:** The system must detect when a file previously auto-migrated by the tool has been manually modified since migration, and warn the engineer to re-analyse before re-running
- **FR27:** The system must halt and log a contract violation when a mid-migration pattern breaches the terms of the Migration Contract — it must not proceed silently past a contract boundary

### Lumen 8 → Laravel 8 Transformation Rules (Phase A)

The following Lumen-specific patterns must be transformed in Phase A:

| Lumen Pattern | Laravel Equivalent | Transformation Approach |
|---|---|---|
| **Bootstrap (`bootstrap/app.php`)** | Full Laravel bootstrap | Replace `$app = new Laravel\Lumen\Application(...)` with `new Illuminate\Foundation\Application(...)`; add service provider registration |
| **Service Providers** | Laravel service providers | Add `app/Providers/` directory; scaffold `AppServiceProvider`, `AuthServiceProvider`, `EventServiceProvider`; register in `config/app.php` |
| **Middleware** | Laravel middleware stack | Move from `$app->middleware()` and `$app->routeMiddleware()` in bootstrap to `app/Http/Kernel.php` |
| **Routing** | Laravel routing | Convert `$app->get(...)` style to `Route::get(...)` in `routes/web.php` or `routes/api.php`; add `use Illuminate\Support\Facades\Route;` |
| **Configuration** | Laravel config files | Extract config from `$app->configure()` calls to `config/` directory structure (auth.php, database.php, etc.) |
| **Service Container** | Laravel service container | `$app->singleton()` → `app()->singleton()`; update binding syntax to Laravel style |
| **Eloquent Factories** | Laravel factories | Migrate to class-based factories; install `laravel/legacy-factories` for backward compatibility if needed |
| **Exception Handling** | Laravel exception handler | Replace Lumen's simple error handling with `App\Exceptions\Handler` class |
| **Validation** | Laravel validation | No major changes needed; ensure `illuminate/validation` is properly configured |
| **Artisan Commands** | Laravel Artisan | Commands should work with minimal changes; register in `AppServiceProvider` |

**Composer.json Transformation (Phase A):**
- Replace `"laravel/lumen-framework": "^8.0"` with `"laravel/framework": "^8.0"`
- Add required Laravel packages: `illuminate/support`, `illuminate/routing`, etc.
- Remove Lumen-specific packages
- Add `"laravel/legacy-factories": "^1.0"` if factories are detected
- Update `autoload` section to match Laravel PSR-4 structure (`App\\` → `app/`)

---

### FR Area 4 — Validation & Quality Gates

- **FR28:** An engineer can configure an external shell command (`post_phase_command`) that the system executes automatically after each phase apply
- **FR29:** The system must halt the migration and present a diagnostic report if the `post_phase_command` exits with a non-zero code
- **FR30:** The system must display which file was last modified and show its diff when a post-phase command failure occurs
- **FR31:** The system must log every `post_phase_command` execution result (command, exit code, duration, timestamp) to the audit trail
- **FR32:** The system must validate that a git repository exists in the target application before beginning any transformation
- **FR33:** The system must check for a dirty working directory (uncommitted changes) before executing `migrate apply` and offer to stash changes or abort
- **FR34:** The system can execute an optional smoke test (`php artisan --version` or equivalent) after Phase A to verify the application boots correctly before proceeding to Phase B

### FR Area 5 — Knowledge Capture & Pattern Resolution

- **FR35:** When an engineer manually resolves a flagged pattern, the system can prompt them to generalise the resolution for application to similar cases
- **FR36:** An engineer can confirm or reject the system's proposed generalisation before it is applied to additional matching cases
- **FR37:** The system can store resolved patterns and their resolutions in a persistent, application-scoped knowledge base
- **FR38:** An engineer can view the accumulated knowledge base for the current application

### Confidence Scoring Algorithm

The confidence engine uses a **weighted multi-factor scoring model** combining AST complexity analysis with LLM-assisted explanations.

**Mathematical Model: Weighted Additive Scoring**

```
Confidence Score = Σ (Factor_i × Weight_i) × Calibration_Multiplier
```

**Factors (0-100 scale, normalised):**

| Factor | Weight | Description | Calculation |
|---|---|---|---|
| **AST Complexity** | 0.35 | Complexity of the code pattern to transform | Based on: node depth, child node count, nested control structures, trait usage, interface implementations |
| **Cross-File Dependencies** | 0.25 | Number of files affected beyond the primary file | Count of files in blast radius map for this pattern |
| **Custom Code Proximity** | 0.20 | How close the pattern is to custom business logic | Distance (in AST hops) to custom classes/methods; closer = lower score |
| **Rule Maturity** | 0.15 | How many times this rule pattern has been successfully applied | Success count from knowledge base; caps at 10+ successes = 100% |
| **Test Coverage** | 0.05 | Whether the affected code has associated tests | Binary: has test file = 100, no test = 0 |

**Calibration Multiplier:** Applied post-calculation based on historical accuracy:
- 1.0 = calibrated (default)
- < 1.0 = historically overconfident (reduce scores)
- > 1.0 = historically underconfident (increase scores)

**Score Interpretation:**
- **85-100:** Auto-migrate (green)
- **60-84:** Suggested auto-migrate with review (yellow)
- **30-59:** Manual review required (orange)
- **0-29:** High risk, human resolution required (red)

**Plain-English Explanations:**
Generated via the approved AI tool (LLM) using a structured prompt:
```
Pattern: {pattern_type}
AST Complexity Score: {score_breakdown}
Cross-file Impact: {file_count} files
Custom Code Proximity: {distance} hops to {custom_class}
Rule Maturity: {success_count} prior successes
Recommendation: {auto/manual} because {primary_factor} at {value}
```

The LLM returns a human-readable explanation like: *"This pattern is flagged for manual review because it touches 4 files and is only 2 AST hops away from your custom AuthService class, which the symbol index shows has 3 trait dependencies."*

---

### State Registry & Knowledge Base Specification

**Storage Format:** JSON files (human-readable, versionable, cross-platform)

**Location:**
- State Registry: `.larapgrader/state.json` in the target application root
- Knowledge Base: `.larapgrader/knowledge-base.json` in the target application root
- Audit Trail: `.larapgrader/audit.log` (append-only JSONL format)

**State Registry Schema (`state.json`):**
```json
{
  "version": "1.0",
  "app": "gateway-api",
  "phase": "A",
  "status": "in_progress|completed|failed",
  "applied_rules": [
    {
      "rule_id": "lumen8.routes.auth_middleware",
      "file": "app/Http/routes.php",
      "timestamp": "2026-05-02T10:30:00Z",
      "snapshot_id": "snap_001",
      "confidence_score": 92
    }
  ],
  "current_layer": "middleware",
  "last_successful_run": "2026-05-02T10:30:00Z"
}
```

**Knowledge Base Schema (`knowledge-base.json`):**
```json
{
  "version": "1.0",
  "patterns": [
    {
      "pattern_hash": "sha256_of_ast_fingerprint",
      "pattern_type": "lumen8.routes.auth_middleware",
      "resolution": "auto|manual",
      "resolution_code": "/* transformed code */",
      "success_count": 5,
      "last_applied": "2026-05-02T10:30:00Z",
      "applied_to": ["gateway-api", "cms-be"]
    }
  ]
}
```

**Concurrency Strategy:**
- File locking via `flock()` (cross-platform compatible)
- Atomic writes using temp file + rename
- State file validation on each read (schema version check)

---

### FR Area 6 — Governance & Audit

- **FR39:** The system must record every transformation decision to an append-only audit trail (pattern matched, action taken, confidence score, timestamp, actor)
- **FR40:** The system must record every human approval or rejection decision to the audit trail with timestamp and optional free-text rationale
- **FR41:** A tech lead can export the full audit trail as a structured report suitable for compliance sign-off
- **FR42:** The system must never include `.env` file contents or secrets in any report, log, or AI prompt payload

### FR Area 7 — CLI Interface & Configuration

- **FR43:** All commands must provide a comprehensive `--help` output including description, flags, example invocations, and exit codes
- **FR44:** All commands must return meaningful, documented exit codes (0 = success, 1 = halted by confidence gate, 2 = error, 3 = human review required)
- **FR45:** All commands must support `--no-ansi` flag for CI and logging environments
- **FR46:** All commands must support `--verbose` and `--quiet` flags
- **FR47:** The system must read tool-level configuration (thresholds, AI endpoint, `post_phase_command`) from a `larapgrader.yaml` file at project root
- **FR48:** All file path operations must function correctly on Windows, macOS, and Linux
- **FR49:** The system must detect and warn when the target application's `vendor/` directory is missing or stale before beginning analysis or transformation

---

## Non-Functional Requirements

### Performance

- **NFR1:** `larapgrader analyse` must complete analysis of a single application (up to 100,000 lines of PHP) within 5 minutes on a standard developer machine (8-core CPU, 16GB RAM)
- **NFR2:** `migrate plan` (dry-run diff generation) must complete within 3 minutes for a single application layer
- **NFR3:** `migrate apply` for a single layer must not block the engineer's terminal for more than 60 seconds without emitting progress output — long operations must stream progress, not appear frozen
- **NFR4:** The state registry read/write operations must not add more than 5 seconds overhead to any command execution

### Security

- **NFR5:** The AST core (analyse, plan, apply) must make zero outbound network calls. Any network activity during these operations must be treated as a defect.
- **NFR6:** LLM-assisted features must only transmit code snippets explicitly selected for analysis — never entire files, never directory trees, never configuration files
- **NFR7:** The tool must never read, log, or include `.env` file contents in any output, report, AI prompt, or audit trail entry
- **NFR8:** The audit trail must be append-only — existing entries must not be modifiable after being written
- **NFR9:** All AI prompt payloads must be logged locally before transmission so engineers can audit exactly what was sent to the approved AI tool

### Reliability

- **NFR10:** A `migrate apply` interrupted mid-execution (process kill, power loss, network drop) must leave the application in a recoverable state — the next `migrate apply` run must detect the interrupted state and offer resume or rollback
- **NFR11:** The state registry must use atomic write operations — partial writes must not corrupt the migration state
- **NFR12:** If `post_phase_command` fails, the system must halt without applying any further transformations and must preserve all file changes made so far in their current state for engineer inspection
- **NFR13:** The rollback mechanism must restore the application to its exact pre-apply state, including all files modified or created during the apply operation

### Integration

- **NFR14:** The `post_phase_command` integration must support any shell command executable on the host OS — the tool must not impose restrictions on the command format beyond OS-level execution
- **NFR15:** The git integration must support git version 2.30 or later and must function correctly with standard branch and stash workflows
- **NFR16:** The Rector integration must pin to a specific Rector version declared in the tool's `composer.json` — tool upgrades that change the Rector version must document the impact in the changelog
- **NFR17:** The approved AI tool integration must be configurable via `larapgrader.yaml` (endpoint, model, timeout) and must degrade gracefully if the endpoint is unreachable — LLM features unavailable, core migration unaffected

### Codebase Scale Limits

- **NFR18:** The tool must handle single applications up to 500 files / 150,000 lines of PHP without configuration changes
- **NFR19:** Applications exceeding these limits must receive a warning with an option to proceed — not a hard failure
- **NFR20:** Memory consumption during analysis must not exceed 512MB peak on the recommended minimum hardware

### Testing Strategy for larapgrader

**Testing Framework:** **Pest** (PHP testing framework)

**Test Categories:**

| Test Type | Tool | Coverage Target |
|---|---|---|
| **Unit Tests** | Pest | Rule engine, AST analysis, confidence scoring algorithm, state registry operations |
| **Integration Tests** | Pest + Symfony Process | Rector integration, git operations, composer.json transformations |
| **CLI Tests** | Pest + Symfony Process | All CLI commands (`analyse`, `migrate plan`, `migrate apply`, etc.) with mocked inputs |
| **End-to-End Tests** | Pest + test Lumen 8 fixtures | Full migration run on sample Lumen 8 apps in `tests/fixtures/` |
| **Cross-Platform Tests** | GitHub Actions (Windows + Linux + macOS) | File path handling, git operations, shell command execution |

**Test Fixtures:**
- `tests/fixtures/lumen8-basic/` — Minimal Lumen 8 app
- `tests/fixtures/lumen8-custom/` — Lumen 8 with custom auth, middleware, service providers
- `tests/fixtures/lumen8-domain/` — Multi-service domain setup for domain analysis tests

**Parallel Processing Implementation:**
- Use `symfony/process` for process management
- Use `amphp/parallel` or `ReactPHP` for async parallelism
- **Default:** 10 files per parallel batch (configurable via `larapgrader.yaml`)
- **Fallback:** Single-threaded mode for environments without pcntl/parallel support
- **Progress reporting:** Stream progress updates to terminal during parallel analysis (NFR3 compliance)

**Performance Target (with parallel processing):**
- `larapgrader analyse`: 100k lines in < 5 minutes (achieved via parallel file processing)
- Single file analysis: < 100ms average
- State registry read/write: < 5 seconds (NFR4 compliant)

---
