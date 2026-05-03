# Test Helpers

Use helper classes in this folder to keep test setup deterministic and reusable.

- Prefer static builders for fixture arrays used across multiple tests.
- Keep helpers side-effect free.
- Unit tests must not perform live external calls (HTTP, CLI subprocess, or remote services); mock contracts instead.
- Avoid random data unless a test explicitly requires fuzzing.
