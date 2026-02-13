# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

Siphon (`monadial/php-si`) — a PHP library for SI units and unit systems. Provides immutable, type-safe quantity and unit-of-measure abstractions with arbitrary precision arithmetic. Requires PHP >= 8.4.

## Commands

```bash
# Run tests
composer phpunit

# Run single test file
vendor/bin/phpunit tests/Path/To/TestFile.php

# Static analysis (PHPStan max level + ShipMonk rules)
composer phpstan

# Code style check / auto-fix
composer phpcs
composer phpcbf

# All quality checks run automatically on git commit via GrumPHP
```

### Docker development

```bash
docker-compose up -d
docker exec -it php-siphon-84 bash
```

## Architecture

### Core abstractions

- **`Quantity`** (`src/Quantity.php`) — abstract readonly base for all measurable quantities. Generic over `UnitOfMeasure`. Holds a `BigDecimal` value and a unit. Conversion via `scaleTo(UnitOfMeasure)`.
- **`UnitOfMeasure`** (`src/UnitOfMeasure.php`) — abstract readonly base for all units. Factory method `make(): static`. Each unit exposes a `factor(): BigDecimal` used for conversions.
- **`System`** interface (`src/System/System.php`) — defines `factor(): BigNumber` for unit system multipliers.
- **`MetricSystem`** enum (`src/System/MetricSystem.php`) — implements `System` with all SI prefixes (YOCTO through YOTTA). Each case returns its `BigDecimal` factor.

### Pattern for adding a new unit domain (e.g. Length)

1. **Quantity subclass**: `src/Unit/Space/Length.php` — `final readonly class Length extends Quantity`
2. **Unit base**: `src/Unit/Space/LengthUnit.php` — abstract class with `factor(): BigDecimal`
3. **Concrete units**: `src/Unit/Space/Length/Meters.php`, `Centimeters.php`, etc. — each delegates factor to `MetricSystem::CASE->factor()`

This pattern repeats for every physical dimension.

### Key dependencies

- **`brick/math`** — `BigDecimal`/`BigNumber` for all numeric values (no floats)
- **`fp4php/functional`** — functional programming primitives (Option, Either, ArrayList, HashMap)

### Design principles

- All value objects are `readonly` and immutable
- PHPStan generics: `@template-covariant TUoM of UnitOfMeasure` on Quantity
- PSR-4 autoloading under `Monadial\Siphon` namespace

## Quality gates

- PHPStan: max level, ShipMonk rules with checked exceptions, zero suppressions/baseline
- PHPUnit: strict mode, `failOnWarning`, `failOnRisky`, `requireCoverageMetadata`
- PHPCS: `pixelfederation/coding-standards` ruleset, PHP 8.4
- EditorConfig: 4-space indent for PHP, LF line endings
