## Deferred from: code review of 1-2-create-service-container.md (2026-05-03)

- PHPStan errors for placeholder classes in `src/Container/ContainerFactory.php` — deferred because placeholder implementations are intentionally referenced by Story 1.2 and will be introduced in later stories.

## Deferred from: code review of 1-3-setup-pest-php.md (2026-05-03)

- sprint-status file extension/content mismatch may break tools expecting strict YAML parse in `_bmad-output/implementation-artifacts/sprint-status.yaml` — deferred as pre-existing process/format issue outside this story's direct code changes.

## Deferred from: code review of 1-8-add-ci-static-analysis.md (2026-05-03)

- Hard-coded PHP 8.3 with no version strategy — Multi-version testing deferred to post-MVP enhancement; current spec choice is intentional for MVP
- No `.gitattributes` to normalize line endings — Pre-existing project structure; cross-platform line ending normalization is separate infrastructure concern
- phpstan only analyzes `src/`, not `tests/` — Test static analysis coverage is intentional per spec; test analysis is separate concern for future story
- bin/larapgrader CLI not integration tested in workflow — CLI bootstrap testing is separate integration concern; workflow properly focused on code quality gates
- No timeout recovery/retry logic — Graceful degradation acceptable for MVP; can enhance if timeout issues occur in practice
- Pull request cache pollution (low probability) — Edge case with non-empty hash fallback; acceptable risk; revisit if cache conflicts observed
