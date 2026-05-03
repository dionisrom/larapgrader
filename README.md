# LaraGrader

Lumen to Laravel migration orchestrator.

## Code Quality

This project follows **PSR-12** coding standards and uses **PHPStan level 8** for static analysis.

### Running Code Quality Checks

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

### Testing

```bash
vendor/bin/pest tests/
```

All tests use [Pest](https://pestphp.com/) with Mockery for mocking external dependencies.
