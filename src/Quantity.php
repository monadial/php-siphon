<?php

declare(strict_types=1);

namespace Monadial\Siphon;

use Brick\Math\BigDecimal;
use Brick\Math\BigInteger;
use Brick\Math\RoundingMode;
use Closure;
use LogicException;

/**
 * @psalm-consistent-constructor
 * @psalm-immutable
 * @template-covariant TUoM of UnitOfMeasure
 */
abstract readonly class Quantity
{
    /**
     * @psalm-api
     * @param BigDecimal|int|float|string $value
     * @param TUoM $uom
     * @return static
     */
    public static function from(BigDecimal|int|float|string $value, UnitOfMeasure $uom): static
    {
        /** @psalm-suppress UnsafeGenericInstantiation */
        return new static(BigDecimal::of($value), $uom);
    }

    /**
     * @psalm-api
     * @param BigDecimal|int|float|string $value
     * @param TUoM $from
     * @param TUoM $to
     * @return static
     */
    public static function convert(
        BigDecimal|int|float|string $value,
        UnitOfMeasure $from,
        UnitOfMeasure $to,
    ): static {
        return self::from($value, $from)->scaleTo($to);
    }

    public static function parse(string $input): static
    {
        if (!preg_match('/^\s*([+\-]?(?:\d+(?:\.\d+)?|\.\d+)(?:[eE][+\-]?\d+)?)\s*(.+?)\s*$/', $input, $m)) {
            throw new LogicException(sprintf('Unable to parse quantity from "%s"', $input));
        }

        $value = BigDecimal::of($m[1]);
        $unitToken = self::normalizeToken($m[2]);
        $unitMap = self::unitAliasesForStaticClass();

        if (!array_key_exists($unitToken, $unitMap)) {
            throw new LogicException(sprintf('Unknown unit "%s" for quantity %s', $m[2], static::class));
        }

        /** @var class-string<UnitOfMeasure> $unitClass */
        $unitClass = $unitMap[$unitToken];

        /** @psalm-suppress UnsafeGenericInstantiation */
        return new static($value, $unitClass::make());
    }

    /**
     * @param TUoM $uom
     */
    public function __construct(
        protected BigDecimal $value,
        protected UnitOfMeasure $uom,
    ) {
    }

    /**
     * @psalm-api
     */
    public function value(): BigDecimal
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value . ' ' . $this->uom->symbol();
    }

    public function toScientificString(int $precision = 6): string
    {
        return sprintf('%.' . $precision . 'E %s', (float) (string) $this->value, $this->uom->symbol());
    }

    /**
     * @psalm-api
     * @return TUoM
     */
    public function uom(): UnitOfMeasure
    {
        return $this->uom;
    }

    /**
     * @param TUoM $uom
     * @return static
     */
    public function scaleTo(UnitOfMeasure $uom): static
    {
        /** @psalm-suppress ImpureMethodCall */
        return match (true) {
            $uom->equals($this->uom) => $this->with($this->value, $uom),
            default => $this->with(
                $this->value
                    ->plus($this->uom->offset())
                    ->multipliedBy($this->uom->factor())
                    ->dividedBy($uom->factor(), max($this->value->getScale(), 10) + 10, RoundingMode::HALF_UP)
                    ->minus($uom->offset()),
                $uom,
            ),
        };
    }

    // ---------------------------------------------------------------
    // DSL convenience
    // ---------------------------------------------------------------

    /**
     * Convert to a different unit (Squants-style alias for scaleTo).
     *
     * @param TUoM $uom
     * @return static
     */
    public function in(UnitOfMeasure $uom): static
    {
        return $this->scaleTo($uom);
    }

    /**
     * Extract the numeric value in the given unit (Squants-style).
     *
     * @param TUoM $uom
     */
    public function to(UnitOfMeasure $uom): BigDecimal
    {
        return $this->scaleTo($uom)->value;
    }

    /**
     * Apply a transformation to the value, preserving type and unit.
     *
     * @param Closure(BigDecimal): BigDecimal $fn
     * @return static
     */
    public function map(Closure $fn): static
    {
        /** @psalm-suppress ImpureFunctionCall */
        return $this->with($fn($this->value), $this->uom);
    }

    // ---------------------------------------------------------------
    // Arithmetic (same dimension)
    // ---------------------------------------------------------------

    /**
     * @psalm-api
     * @return static
     */
    public function plus(self $that): static
    {
        return $this->with(
            $this->value->plus($that->scaleTo($this->uom)->value),
            $this->uom,
        );
    }

    /**
     * @psalm-api
     * @return static
     */
    public function minus(self $that): static
    {
        return $this->with(
            $this->value->minus($that->scaleTo($this->uom)->value),
            $this->uom,
        );
    }

    /**
     * Multiply by a scalar.
     *
     * @psalm-api
     * @return static
     */
    public function times(BigDecimal|BigInteger|int|float|string $scalar): static
    {
        return $this->with(
            $this->value->multipliedBy($scalar),
            $this->uom,
        );
    }

    /**
     * Divide by a scalar.
     *
     * @psalm-api
     * @return static
     */
    public function dividedBy(BigDecimal|BigInteger|int|float|string $scalar, int $scale = 20): static
    {
        return $this->with(
            $this->value->dividedBy($scalar, $scale, RoundingMode::HALF_UP),
            $this->uom,
        );
    }

    /**
     * @psalm-api
     * @return static
     */
    public function negate(): static
    {
        return $this->with($this->value->negated(), $this->uom);
    }

    /**
     * @psalm-api
     * @return static
     */
    public function abs(): static
    {
        return $this->with($this->value->abs(), $this->uom);
    }

    // ---------------------------------------------------------------
    // Comparisons
    // ---------------------------------------------------------------

    /**
     * @psalm-api
     */
    public function isEqualTo(self $that): bool
    {
        return $this->toBaseValue()->isEqualTo($that->toBaseValue());
    }

    /**
     * @psalm-api
     */
    public function isGreaterThan(self $that): bool
    {
        return $this->toBaseValue()->isGreaterThan($that->toBaseValue());
    }

    /**
     * @psalm-api
     */
    public function isLessThan(self $that): bool
    {
        return $this->toBaseValue()->isLessThan($that->toBaseValue());
    }

    /**
     * @psalm-api
     */
    public function isGreaterThanOrEqualTo(self $that): bool
    {
        return $this->toBaseValue()->isGreaterThanOrEqualTo($that->toBaseValue());
    }

    /**
     * @psalm-api
     */
    public function isLessThanOrEqualTo(self $that): bool
    {
        return $this->toBaseValue()->isLessThanOrEqualTo($that->toBaseValue());
    }

    /**
     * Approximate equality within a tolerance.
     *
     * @psalm-api
     */
    public function approx(self $that, self $tolerance): bool
    {
        $diff = $this->toBaseValue()->minus($that->toBaseValue())->abs();

        return $diff->isLessThanOrEqualTo($tolerance->toBaseValue());
    }

    /**
     * @psalm-api
     * @return static
     */
    public function min(self ...$others): static
    {
        $result = $this;
        foreach ($others as $other) {
            if ($other->isLessThan($result)) {
                $result = $other->scaleTo($this->uom);
            }
        }

        return $result;
    }

    /**
     * @psalm-api
     * @return static
     */
    public function max(self ...$others): static
    {
        $result = $this;
        foreach ($others as $other) {
            if ($other->isGreaterThan($result)) {
                $result = $other->scaleTo($this->uom);
            }
        }

        return $result;
    }

    // ---------------------------------------------------------------
    // Base-unit conversion helper
    // ---------------------------------------------------------------

    /**
     * Returns the value normalized to base units (factor * value + offset).
     */
    protected function toBaseValue(): BigDecimal
    {
        /** @psalm-suppress ImpureMethodCall */
        return $this->value
            ->plus($this->uom->offset())
            ->multipliedBy($this->uom->factor());
    }

    // ---------------------------------------------------------------
    // Internal helpers
    // ---------------------------------------------------------------

    /**
     * @psalm-pure
     * @return static
     */
    private function with(BigDecimal $value, UnitOfMeasure $uom): static
    {
        /** @psalm-suppress UnsafeGenericInstantiation */
        return new static($value, $uom);
    }

    /**
     * @return array<string, class-string<UnitOfMeasure>>
     */
    private static function unitAliasesForStaticClass(): array
    {
        /** @var array<class-string<self>, array<string, class-string<UnitOfMeasure>>> $cache */
        static $cache = [];

        if (array_key_exists(static::class, $cache)) {
            return $cache[static::class];
        }

        $quantityClassPath = substr(static::class, strlen('Monadial\\Siphon\\'));
        if (!is_string($quantityClassPath) || $quantityClassPath === '') {
            throw new LogicException(sprintf('Unable to infer class path for quantity %s', static::class));
        }

        $unitDir = __DIR__ . '/' . str_replace('\\', '/', $quantityClassPath);
        $unitFiles = glob($unitDir . '/*.php');

        if ($unitFiles === false || $unitFiles === []) {
            throw new LogicException(sprintf('No unit directory found for quantity %s', static::class));
        }

        $map = [];
        foreach ($unitFiles as $unitFile) {
            $shortName = pathinfo($unitFile, PATHINFO_FILENAME);
            $unitClass = static::class . '\\' . $shortName;

            if (!is_a($unitClass, UnitOfMeasure::class, true)) {
                continue;
            }

            /** @var UnitOfMeasure $unit */
            $unit = $unitClass::make();

            foreach ($unit->aliases() as $alias) {
                $map[self::normalizeToken($alias)] = $unitClass;
            }
        }

        $cache[static::class] = $map;

        return $map;
    }

    private static function normalizeToken(string $token): string
    {
        $normalized = strtolower(trim($token));
        $normalized = preg_replace('/\s*\/\s*/', '/', $normalized) ?? $normalized;
        $normalized = preg_replace('/\s+/', ' ', $normalized) ?? $normalized;

        return $normalized;
    }
}
