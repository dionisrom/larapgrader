# LaraGrader

> ⚠️ **Note:** This package is currently a work-in-progress. The package name `your-org/larapgrader` in badges and installation examples is a placeholder. Before using or publishing, replace it with your actual organization and package name.

[![Latest Version](https://img.shields.io/packagist/v/your-org/larapgrader.svg?style=flat-square)](https://packagist.org/packages/your-org/larapgrader)
[![CI Status](https://img.shields.io/github/actions/workflow/status/your-org/larapgrader/ci.yml?style=flat-square)](https://github.com/your-org/larapgrader/actions)
[![Coverage](https://img.shields.io/codecov/c/github/your-org/larapgrader/main?style=flat-square)](https://codecov.io/gh/your-org/larapgrader)
[![PHP Version](https://img.shields.io/packagist/php-v/your-org/larapgrader.svg?style=flat-square)](https://packagist.org/packages/your-org/larapgrader)
[![License](https://img.shields.io/packagist/l/your-org/larapgrader.svg?style=flat-square)](LICENSE)

**Lumen to Laravel migration orchestrator** — Analyze, plan, and execute automated migrations from Lumen to Laravel with confidence.

## 📋 Table of Contents

- [Installation](#installation)
- [Quick Start](#quick-start)
- [Commands](#commands)
- [Troubleshooting](#troubleshooting)
- [Code Quality](#code-quality)
- [Testing](#testing)
- [Contributing](#contributing)

## 🚀 Quick Start

First-time setup wizard:

```bash
# Run the interactive onboarding wizard
./bin/larapgrader

# Or use the onboarding command directly (when available)
./bin/larapgrader onboard
```

The wizard will guide you through:
- Verifying system requirements (PHP 8.3+, Composer)
- Checking Ollama LLM availability (optional, for AI-powered explanations)
- Configuring your project paths

### Analyze a Lumen Project

```bash
./bin/larapgrader analyse /path/to/lumen-app
```

This generates a pre-migration report with:
- AST analysis of your codebase
- Symbol index and dependency mapping
- Confidence scoring for migration readiness
- Blast radius calculation for changes
- Incompatible package detection
- Time estimates for migration

### Migrate a Lumen Project

```bash
# Dry-run (see what would change)
./bin/larapgrader migrate /path/to/lumen-app --dry-run

# Execute Phase A (Lumen → Laravel 8)
./bin/larapgrader migrate /path/to/lumen-app --phase=A

# Execute Phase B (Laravel 8 → Laravel 13)
./bin/larapgrader migrate /path/to/lumen-app --phase=B

# Full migration with all phases
./bin/larapgrader migrate /path/to/lumen-app
```

## 📦 Installation

Choose **Global Installation** (recommended for daily use) or **Project-Local** (for CI/CD or testing).

### Global Installation (Recommended)

Install once globally, use in any project:

```bash
composer global require your-org/larapgrader
```

Make sure your global Composer bin directory is in your PATH:

**On Linux/macOS:**
```bash
# Add to your shell profile (.bashrc, .zshrc, etc.)
export PATH="$PATH:$(composer global config bin-dir --absolute)"
```

**On Windows (PowerShell):**
```powershell
$binDir = & composer global config bin-dir --absolute
$env:PATH += ";$binDir"
# To persist permanently, use: [Environment]::SetEnvironmentVariable("PATH", ...)
```

**On Windows (Command Prompt):**
```cmd
for /f "tokens=*" %i in ('composer global config bin-dir --absolute') do setx PATH "%PATH%;%i"
```

Verify the installation:
```bash
larapgrader --help
```

### Project-Local Installation

```bash
composer require --dev your-org/larapgrader
```

**For development,** use:
```bash
composer install  # or composer install --dev to include dev tools (PHPStan, PHP-CS-Fixer)
./bin/larapgrader --help
```

Then use via:

```bash
./bin/larapgrader --help
# or
vendor/bin/larapgrader --help
```

### Requirements

- PHP 8.3 or higher
- Composer 2.x
- [Optional] Ollama (only needed for LLM-powered explanations via `analyse --deep`; use `--no-llm` flag to skip)
- Project directory: Writable `.larapgrader/` directory will be created for snapshots and configuration

**Development Tools (optional):**
- PHPStan and PHP-CS-Fixer require `composer install --dev` to run code quality checks locally

## 🎮 Commands

### `analyse` — Pre-Migration Analysis

Analyzes a Lumen project and generates a comprehensive migration readiness report.

```bash
./bin/larapgrader analyse [options] [<path>]
```

**Options:**
| Option | Description |
|--------|-------------|
| `--output=FILE` | Write report to FILE instead of stdout |
| `--format=FORMAT` | Output format: `text`, `json`, `html` (default: `text`) |
| `--deep` | Enable deep analysis with LLM explanations |
| `--no-llm` | Disable LLM features (faster, no Ollama needed) |

**Example:**
```bash
./bin/larapgrader analyse ./my-lumen-app --format=json --output=report.json
```

### `migrate` — Execute Migration

Migrates a Lumen project to Laravel through automated transformation phases.

```bash
./bin/larapgrader migrate [options] [<path>]
```

**Options:**
| Option | Description |
|--------|-------------|
| `--phase=A\|B` | Run specific phase (A: Lumen→Laravel8, B: Laravel8→13) |
| `--dry-run` | Preview changes as a unified diff (written to stdout or file with `--output`) |
| `--force` | Skip confirmation prompts |
| `--rollback` | Rollback to last snapshot in `.larapgrader/snapshots/` if migration fails |
| `--contract=FILE` | Use custom migration contract file |

**Example:**
```bash
# Preview changes
./bin/larapgrader migrate ./my-lumen-app --dry-run

# Run Phase A only
./bin/larapgrader migrate ./my-lumen-app --phase=A

# Full migration with rollback on failure
./bin/larapgrader migrate ./my-lumen-app --rollback
```

### `contract` — Migration Contract Management

Manage migration contracts that define governance rules and thresholds.

```bash
./bin/larapgrader contract [options] [<path>]
```

**Options:**
| Option | Description |
|--------|-------------|
| `--validate` | Validate contract against project |
| `--scaffold` | Generate a new contract template |
| `--threshold=LEVEL` | Set confidence threshold (low\|medium\|high) |

### `report` — Generate Reports

Generate various reports about migration status and audit trails.

```bash
./bin/larapgrader report [options] [<path>]
```

**Options:**
| Option | Description |
|--------|-------------|
| `--type=TYPE` | Report type: `pre-migration`, `audit`, `progress` |
| `--format=FORMAT` | Output format: `text`, `json`, `html` |
| `--output=FILE` | Write to file instead of stdout |

### `knowledge` — Knowledge Base Management

View and manage the knowledge base of migration patterns.

```bash
./bin/larapgrader knowledge [options]
```

**Options:**
| Option | Description |
|--------|-------------|
| `--view` | View stored patterns |
| `--export=FILE` | Export knowledge base to file |
| `--import=FILE` | Import patterns from file |

### `onboard` — First-Run Wizard

Interactive setup wizard for new users (also runs automatically on first use).

```bash
./bin/larapgrader onboard
```

## ❗ Troubleshooting

### "vendor/autoload.php not found"

**Problem:** Running `./bin/larapgrader` gives an autoload error.

**Solution:**
```bash
composer install
```

### "PHP 8.3 required, X.Y.Z found"

**Problem:** Your PHP version is too old.

**Solution:** Upgrade to PHP 8.3 or higher, or use a version manager like `phpenv` or Docker.

### Ollama Connection Failed

**Problem:** LLM features fail with connection error.

**Solution:**
1. Install Ollama from [ollama.ai](https://ollama.ai)
2. Start the Ollama service: `ollama serve`
3. Pull a model: `ollama pull codellama`
4. Verify: `ollama list`

To run without Ollama:
```bash
./bin/larapgrader analyse ./app --no-llm
```

### Migration Rollback Failed

**Problem:** `--rollback` didn't restore files.

**Solution:**
1. Check if snapshots exist: `ls -la .larapgrader/snapshots/` (or `dir .larapgrader\snapshots\` on Windows)
2. If snapshots exist, re-run migration with `--rollback` flag
3. If no snapshots: manually restore from git with `git checkout -- .`
4. Ensure you're using a clean git working directory (no uncommitted changes before migration)

### Permission Denied on bin/larapgrader

**Problem:** Cannot execute the binary.

**Solution:**
```bash
chmod +x bin/larapgrader
```

### Composer Memory Limit

**Problem:** Composer install fails with memory error.

**Solution:**
```bash
COMPOSER_MEMORY_LIMIT=-1 composer install
```

## 🔍 Code Quality

This project follows **PSR-12** coding standards and uses **PHPStan level 8** for static analysis.

### Running Code Quality Checks
**Note:** These tools require development dependencies. Install with `composer install --dev`.
#### PHPStan (Static Analysis - Level 8)

```bash
vendor/bin/phpstan analyse src/
```

PHPStan is configured in `phpstan.neon` and checks:
- Type coverage at level 8 (highest strictness)
- All production code in the `src/` directory
- No return type hints in iterables (must specify array key/value types)
- Proper nullable type declarations
- Missing parameter types

#### PHP CS Fixer (Code Style - PSR-12)

```bash
# Check code style (dry-run)
vendor/bin/php-cs-fixer check --diff

# Fix code style automatically
vendor/bin/php-cs-fixer fix
```

PHP CS Fixer is configured in `.php-cs-fixer.php` and enforces:
- PSR-12 coding standard
- Strict types declaration on all files
- Ordered imports
- Single quotes for strings
- No unused imports
- Proper spacing and formatting

### Development Standards

All new code must:

1. **Pass PHPStan level 8** - Run `vendor/bin/phpstan analyse src/` before committing
2. **Pass PHP CS Fixer checks** - Run `vendor/bin/php-cs-fixer check --diff` to verify formatting
3. **Include comprehensive tests** - Use Pest for all unit, integration, and end-to-end tests
4. **Declare strict types** - All PHP files should start with `declare(strict_types=1);`

## 🧪 Testing

```bash
vendor/bin/pest tests/
```

All tests use [Pest](https://pestphp.com/) with Mockery for mocking external dependencies.

### Running with Coverage

```bash
vendor/bin/pest --coverage
```

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Run code quality checks (see [Code Quality](#code-quality))
4. Commit your changes (`git commit -m 'Add amazing feature'`)
5. Push to the branch (`git push origin feature/amazing-feature`)
6. Open a Pull Request

## 📄 License

MIT License. See [LICENSE](LICENSE) for details.

## 🏗️ Architecture

LaraGrader uses a modular architecture with:
- **Service Container** (PHP-DI) for dependency injection
- **AST Parser** (nikic/php-parser) for code analysis
- **Symfony Console** for CLI interface
- **Pest** for testing with Mockery mocks
- **LLM Integration** via Ollama for AI-powered insights

## 📚 Documentation

Full documentation is available in the [`docs/`](docs/) directory.

Key documents:
- [Architecture Overview](docs/architecture.md)
- [Migration Contract Specification](docs/contract.md)
- [CLI Reference](docs/cli-reference.md)
