---
stepsCompleted: [1]
inputDocuments: []
session_topic: 'Upgrader application to migrate enterprise custom Lumen 8 apps to Laravel 13'
session_goals: 'Ideate features, architecture approaches, and strategies for a tool like Laravel Shift but with support for custom code and custom dependencies'
selected_approach: 'AI-Recommended Techniques'
techniques_used: []
ideas_generated: []
context_file: ''
---

# Brainstorming Session Results

**Facilitator:** Boggie
**Date:** 2026-04-15

## Session Overview

**Topic:** Upgrader application to migrate enterprise custom Lumen 8 applications to Laravel 13
**Goals:** Generate innovative ideas for a migration tool that handles custom code, custom dependencies, and the Lumen 8 → Laravel 13 path — going beyond what Laravel Shift offers for pure framework apps

### Session Setup

User is running enterprise PHP 8.3 applications built on Lumen 8 with custom dependencies and custom code. Goal is to create a semi-automated upgrader tool that can intelligently handle non-standard patterns and custom packages, not just vanilla Lumen/Laravel codebases.

Custom packages are plain PHP (helpers, service clients) — not Laravel/Lumen apps. Apps form a domain: Gateway API, CMS BE, Delivery API + other services.

---

## Phase 1: Expansive Exploration — What If Scenarios + Reversal Inversion

### Selected / Confirmed Ideas

**[Idea #1 — Semantic App Fingerprint]:** Build an intent model of the app before touching any file — maps routes, middleware chains, service bindings, custom facades, not just syntax.

**[Idea #4 — Migration Confidence Score]:** Every file/component gets a 0–100 migration confidence score so teams know where autonomous migration is safe vs. where human review is mandatory.

**[Idea #5 — Dependency Negotiation Engine]:** Checks internal/external package registries for Laravel 13 compatibility and proposes shimming strategies when compatible versions don't exist.

**[Idea #6 — Tiered Automation]:** Confidence score directly determines automation tier (auto / review / human-decision). Tiers are configurable by the tech lead (combined with Idea #9).

**[Idea #8 — Full Blast Radius Map]:** Dependency impact graph surfacing every custom/non-standard package, its L13 compatibility status, exact files that depend on it (with line numbers), and cascading second-order blocking chains.

**[Idea #9 — Configurable Migration Contract]:** A versioned, committed YAML artifact where the tech lead defines automation tier thresholds and files/paths that require explicit approval before the tool touches them.

**[Idea #11 — Contract Violations Log]:** Mid-migration, if the tool encounters something that violates contract terms it halts and logs rather than proceeding silently.

**[Idea #13 — Knowledge Capture Mode]:** When a developer manually resolves a flagged pattern, the tool watches the diff and offers to apply that resolution to all similar cases — turning human decisions into reusable migration rules.

**[Idea #14 — Rollback Snapshots]:** Named snapshots (git branch/stash/tarball) before each auto-migration batch with human-readable labels. One-command restore to any checkpoint.

**[Idea #15 — Dry Run Diff Report]:** Mandatory dry-run mode producing a git-style diff of every change the tool would make — without touching files. Shareable for tech lead sign-off.

**[Idea #16 — Domain-Aware Migration Orchestrator]:** Treats the entire service domain as the migration unit. Builds a cross-app dependency map and proposes migration sequencing order to prevent integration boundary breakage.

**[Idea #18 — Cross-App Confidence Aggregation]:** A manually resolved pattern in one app automatically propagates as a suggestion to the same pattern across other apps in the domain.

**[Idea #20 — Contract Boundary Detector]:** Identifies inter-service contracts (shared DTOs, event payloads, API response shapes) and flags them as protected boundaries requiring domain-wide review before changes.

**[Idea #21 — Migration Topology View]:** Structured map of the entire domain showing migrated/in-progress/blocked apps, upstream dependencies, and the critical path to full domain migration.

**[Idea #23 — Static Test Suite Generator]:** Auto-generates pre/post migration test suite from: OpenAPI/Swagger docs (contract tests), static code analysis (critical path unit tests), route introspection (catches undocumented endpoints). No traffic logs needed.

**[Idea #24 — Semantic Diff Reporter (Nice to Have)]:** Post-migration behavioral diff — not just code diff — catching silent behavioral regressions the git diff would miss.

**[Idea #28 — Migration Progress Dashboard]:** Local web UI or terminal UI showing real-time domain-wide migration state: per-app progress, blocked items, pending human decisions, confidence distributions.

**[Idea #29+30 — Hybrid LLM Engine]:** Core is deterministic AST-based transformation. LLM invoked only for ambiguous below-threshold cases — to write plain English explanations of why something can't be auto-migrated and propose options with tradeoffs.

**[Idea #32 — Pattern Learning from Resolved Cases]:** Human decisions during migration stored as labelled examples. Tool fine-tunes a local model on the team's specific patterns across app migrations — learns the inconsistency map rather than assuming consistency.

**[Idea #33 — Self-Hosted, Privacy by Design]:** Runs entirely on-premise. Code never leaves client infrastructure. Non-negotiable enterprise requirement and key differentiator.

**[Idea #37 — Audit Trail Export]:** Every decision (automated or human) logged with timestamp, actor, rationale, before/after diff. Exportable as compliance report.

---

## Phase 2: Pattern Recognition — Morphological Analysis

### Morphological Map

| Axis | Options |
|---|---|
| A. Analysis Engine | AST-only / AST+LLM hybrid / Full LLM |
| B. Migration Scope | Single app / App domain / Multi-domain portfolio |
| C. Transformation Mode | Fully automated / Tiered (confidence-gated) / Advisor only |
| D. Custom Code Handling | Pattern matching / Knowledge capture + learning / LLM inference / Plugin rules |
| E. Dependency Analysis | Framework packages only / Framework + plain PHP packages / Full transitive graph |
| F. Safety Net | None / Static generated tests / Swagger-driven contract tests / Both |
| G. Human Interface | CLI only / CLI + Dashboard / CLI + Dashboard + IDE plugin |
| H. Deployment Model | Self-hosted / SaaS / Both |
| I. Inter-service Awareness | None / Blast radius map only / Full domain orchestration with sequencing |
| J. Learning Capability | None / Session-only rules / Persistent cross-app learning model |
| K. Migration Granularity | Whole app / Layer-by-layer / File-by-file / Pattern-by-pattern |

**Notes:** Plain PHP packages handled manually by separate team (out of scope). Layer-by-layer granularity confirmed.

### Combinations

**Combination Alpha (MVP):** AST-only · Single app · Tiered · Pattern matching · Framework+PHP packages · Swagger tests · CLI · Self-hosted · Blast radius map · Session-only rules · Layer-by-layer · + Idea #38 (domain-ready data model)

**Combination Beta (Full Product):** AST+LLM hybrid · App domain · Tiered · Knowledge capture · Full transitive graph · Both test types · CLI+Dashboard · Self-hosted · Full domain orchestration · Persistent learning · Layer-by-layer

**Combination Gamma (Future — Advisor Mode):** LLM-heavy · Multi-domain · Advisor only · LLM inference · Full graph · None · IDE plugin · Self-hosted · Domain orchestration · Persistent learning

### Key Architectural Decision

**[Idea #38 — Domain-Ready Data Model from Day 1]:** Alpha operates on one app at a time but its internal representation always scopes everything under a domain context. Migration rules, confidence scores, pattern library, audit trail — all domain-scoped. Beta is purely feature addition, zero structural debt.

Alpha → Beta transition is **natural iteration, not rework** — provided Idea #38 is implemented. All axes except B and I are purely additive. B and I are resolved by #38.

---

---

## Phase 3: Idea Development — Cross-Pollination

### Ideas from Adjacent Domains

**[Idea #39 — Composable Migration Rule Registry]:** Every Lumen 8 → Laravel 13 transformation is a discrete, versioned, testable rule (`ReplaceRouteGroupRule`, `MigrateServiceProviderRule`, etc.). Rules are independently enabled/disabled per project via the Migration Contract. Custom rules can be authored as plugins. The engine is an ordered pipeline of rules applied per layer.

**[Idea #40 — Migration State Registry]:** Local state file tracking which transformation rules have been applied to which files, in which order, and when. Running the tool twice is safe — already-applied rules are skipped. Partial migrations are resumable. State file is committed to the repo.

**[Idea #41 — Migration Rule Versioning]:** Transformation rules are versioned. If a rule is updated, the tool flags files migrated with older rule versions — *"Migrated with rule v1.2, rule v1.4 now available. Re-migrate?"*

**[Idea #42 — Baseline Mode]:** On first run generates a baseline of all known migration issues. Subsequent runs only report new issues introduced since baseline. Critical for CI/CD: prevents flood of pre-existing issues on every PR.

**[Idea #43 — nikic/php-parser Foundation]:** Build on `nikic/php-parser` — the same AST foundation used by PHPStan, Psalm, and Laravel Shift. Proven, maintained, handles all PHP 8.x syntax. Rule authors already know the AST node types.

**[Idea #44 — Plan/Apply Execution Model]:** Primary UX is `migrate plan` (dry-run report) followed by explicit `migrate apply`. No migration ever runs without a preceding plan. ✅ Confirmed alignment with intended UX.

**[Idea #45 — State Drift Detection]:** If a developer manually edits a file the tool previously auto-migrated, the tool detects drift on next run — *"File X was migrated on 2026-04-10 but manually modified since. Re-analyse before re-running."*

**[Idea #46 — Lumen-Specific Rule Sets]:** Rector has no Lumen bootstrap awareness. This tool ships Lumen 8 → Laravel 13 rule sets as first-class citizens: `$app = new Laravel\Lumen\Application()` pattern, stripped service container, Lumen route registration model.

**[Idea #47 — Rector Interoperability — DEPRIORITISED]:** Not needed. Apps already on PHP 8.3, fully compatible with Laravel 13. No PHP version upgrade rules required. Rector's Laravel rules don't cover Lumen→Laravel switching.

### Confirmed Architecture Pillars

1. **Rule Registry (#39) + State Registry (#40) + Plan/Apply (#44)** — execution model
2. **nikic/php-parser (#43) as AST foundation + Lumen-specific rule sets (#46)** — analysis engine, fully owned, no Rector dependency
3. **Baseline mode (#42) + State drift detection (#45)** — CI/CD safety model

---

### Must-Haves (confirmed by Reversal Inversion)
- Dry-run mode (#15)
- Inter-service contract awareness (#20)
- Audit trail (#37)
- Self-hosted / no internet required for code analysis (#33)
- Domain-level orchestration (#16, #21)

---

## Phase 4: Action Planning — Constraint Mapping

### Hard Constraints — Real, Non-Negotiable

**[C1] — Lumen 8 Bootstrap Model is Fundamentally Different from Laravel**
Lumen strips the service container, doesn't use `config/app.php`, bootstraps via `bootstrap/app.php` with flat registration. No 1:1 mapping — requires authoring a migration choreography, not just rule substitution.
**Path through:** Solved by Idea #48 (Two-Phase Architecture) — scope reduced to Lumen→Laravel 8 only. LLM-assisted rule authoring (#49) addresses the knowledge gap.

**[C2] — Custom Code Has No Known Patterns Upfront**
Can't pre-write rules for patterns not yet seen. First app will surface unknown patterns the rule registry has no answer for.
**Path through:** Confidence scoring (#4) and Knowledge Capture (#13) manage this — unknown patterns surface as low-confidence flags, not failures. Tool degrades gracefully.

**[C3] — nikic/php-parser Operates on Single Files**
Cross-file awareness (e.g. class extending custom base extending Lumen base) requires a symbol table across the whole codebase.
**Path through:** Pre-analysis indexing pass — walk all files first, build cross-file symbol index (class hierarchy, trait usage, interface implementations), then apply rules with full context.

**[C4] — State Registry Must Be Conflict-Safe in Team Environments**
Multiple developers running simultaneously could corrupt the state file.
**Path through:** State file is lockable, append-only log (one migration file per run, not a single mutable file). Git conflicts on state file are informative, not destructive.

### Significant Constraints — Real but Workable

**[C5] — OpenAPI/Swagger Docs May Be Incomplete or Absent**
Idea #23 relies partly on Swagger docs. Not all apps may have complete specs.
**Path through:** Swagger is additive, not required. Falls back to route introspection + static path tracing.

**[C6] — Rule Authoring Requires Deep Lumen + Laravel Knowledge**
Writing correct transformation rules requires someone who knows both frameworks.
**Path through:** Idea #49 (LLM-Assisted Rule Authoring). Idea #48 (Two-Phase Architecture) scopes the unique work to Lumen→Laravel 8 only. Start with the 20% of patterns covering 80% of codebase.

**[C7] — Confidence Scoring is Initially Uncalibrated**
First run has no training data behind scores.
**Path through:** Start with heuristic-based scoring. Calibrate empirically after first real migration. Idea #32 gradually replaces heuristics with evidence.

**[C8] — Blast Radius Map Requires Complete Dependency Graph**
Requires resolving composer autoloading, custom namespace mappings, non-standard autoloading in older Lumen apps.
**Path through:** Use `composer show --tree` + autoload map parsing as starting point. Flag non-standard autoloading as manual review.

### Imagined Constraints — Dismissed

- **[C9]** "Need to support all patterns before shipping" — only need your patterns for Alpha.
- **[C10]** "Need a UI to be usable" — CLI + structured report sufficient for Alpha. Dashboard is Beta.
- **[C11]** "AST transformation will break code formatting" — `nikic/php-parser` CloningVisitor preserves formatting for unchanged nodes. Post-pass formatter eliminates the rest.

### New Ideas from Phase 4

**[Idea #48 — Two-Phase Migration Architecture]:**
- **Phase A:** Lumen 8 → Laravel 8 (unique rule set, bounded Lumen-specific delta, your differentiator)
- **Phase B:** Laravel 8 → Laravel 13 (Rector-orchestrated, tool drives it but doesn't author the rules)
- Tool manages both phases as sequential pipeline with validation gate between them
- Dramatically reduces Alpha scope — rule authoring covers one framework switch, not five version upgrades

**[Idea #49 — LLM-Assisted Rule Authoring Mode]:** Developer mode — feed a Lumen code sample, LLM proposes the migration rule as an AST transformation, human validates, committed as verified rule. Accelerates initial rule set without requiring deep expertise upfront.

**[Idea #14 — Refined: On-Demand + Automatic Snapshots]:**
- **Automatic:** Snapshot before every layer migration
- **On-demand:** `migrate snapshot "label"` at any point — between layers, before risky manual interventions, before approving flagged items
- **Snapshot registry:** Full list with context labels (*"auto: pre-routes-layer"*, *"manual: before-resolving-custom-guard"*)
- Dev creates a personal, labelled undo history for the entire migration

### Critical Path to Alpha (Final)

```
1.  Pre-analysis indexer (C3)                    ← unlocks everything else
2.  Lumen 8 → Laravel 8 rule set (#46, #48)      ← scoped down, LLM-assisted (#49)
3.  Rector integration for Laravel 8 → 13 (#48)  ← replaces building L9-L13 rules
4.  Confidence scoring — heuristic (C7)           ← enables plan output
5.  Plan/Apply execution model (#44)              ← the UX shell
6.  Dry-run diff report (#15)                     ← required before any apply
7.  Blast radius map (#8)                         ← surfaces custom package risk
8.  Configurable Migration Contract (#9, #6)      ← team control layer
9.  On-demand + automatic snapshots (#14)         ← safety before and during apply
10. Swagger + route test generator (#23)          ← validation layer
11. Audit trail (#37)                             ← compliance/governance
```

Each step builds on the previous. Nothing in steps 2–11 can safely run without step 1.

---

## Full Session Summary

### Product Vision

A **domain-aware, intelligence-first Lumen 8 → Laravel 13 migration orchestrator** for enterprise PHP service portfolios. Operates across a family of services (Gateway API, CMS BE, Delivery API, etc.) as a single migration unit. Understands inter-service contracts, learns from human decisions, generates its own safety nets, and treats the entire service domain as the migration target — not individual apps in isolation.

### Two-Phase Architecture (Core Strategic Decision)

| Phase | Scope | Engine |
|---|---|---|
| Phase A | Lumen 8 → Laravel 8 | Custom rule set (your unique value) |
| Phase B | Laravel 8 → Laravel 13 | Rector-orchestrated (don't build what exists) |

### MVP (Combination Alpha + Idea #38)

Single-app migration UX with a **domain-ready data model from day 1**. All data scoped under a domain context even when only one app is present. Beta (domain orchestration, cross-app learning, dashboard) is purely additive — no structural rework.

### Architecture Pillars

1. **Rule Registry + State Registry + Plan/Apply** — execution model
2. **nikic/php-parser + Lumen-specific rule sets** — analysis engine, fully owned
3. **Baseline mode + State drift detection** — CI/CD safety model

### Confirmed Feature Set

| # | Feature | Phase |
|---|---|---|
| #4 | Migration confidence scoring (heuristic → learned) | Alpha |
| #6+9 | Configurable Migration Contract with tier control | Alpha |
| #8 | Full blast radius map with cascading dependency chains | Alpha |
| #13 | Knowledge capture — human decisions become reusable rules | Alpha |
| #14 | On-demand + automatic rollback snapshots | Alpha |
| #15 | Mandatory dry-run diff report before any apply | Alpha |
| #23 | Static test suite generator (Swagger + route introspection) | Alpha |
| #33 | Self-hosted, privacy by design — code never leaves infrastructure | Alpha |
| #37 | Full audit trail — exportable compliance report | Alpha |
| #38 | Domain-ready data model from day 1 | Alpha |
| #39 | Composable migration rule registry | Alpha |
| #40 | Migration state registry (idempotent, resumable) | Alpha |
| #42 | Baseline mode for CI/CD integration | Alpha |
| #43 | nikic/php-parser as AST foundation | Alpha |
| #44 | Plan/Apply execution model (`migrate plan` + `migrate apply`) | Alpha |
| #45 | State drift detection | Alpha |
| #46 | Lumen 8 → Laravel 8 rule sets | Alpha |
| #48 | Two-phase migration architecture | Alpha |
| #49 | LLM-assisted rule authoring mode | Alpha |
| #1 | Semantic app fingerprint / intent model | Alpha |
| #11 | Contract violations log — halt on breach | Alpha |
| #16 | Domain-aware migration orchestrator with sequencing | Beta |
| #18 | Cross-app confidence aggregation | Beta |
| #20 | Contract boundary detector (inter-service DTOs/events) | Beta |
| #21 | Migration topology view — domain-wide map | Beta |
| #24 | Semantic diff reporter (behavioral, not just code) | Beta (Nice-to-Have) |
| #28 | Migration progress dashboard (local web/TUI) | Beta |
| #29+30 | Hybrid LLM engine — AST core + LLM for explanations | Beta |
| #32 | Persistent pattern learning from resolved cases | Beta |
| #41 | Migration rule versioning | Beta |
| #10 | CI/CD readiness gate (migration cost delta per PR) | Beta |

### Future / Productization
- **Combination Gamma** — Advisor Mode (no code transformation, pure intelligence layer — extra selling point)
- **Idea #35** — Migration-as-a-Service professional tier
- **Idea #36** — Pluggable rule engine / community ecosystem

### Key Decisions Made
1. **Two-phase architecture** is the correct scope reduction strategy
2. **Domain-ready data model** in Alpha is the only decision that prevents Beta rework
3. **Rector for L8→L13**, not custom rules — don't build what exists
4. **LLM assists rule authoring**, doesn't perform transformations
5. **Plain PHP packages** handled by a separate team — out of tool scope
6. **Self-hosted only** for Alpha — cloud/SaaS is a future consideration
7. **Layer-by-layer** is the migration granularity (routes → providers → models → controllers)
