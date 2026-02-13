<?php

declare(strict_types=1);

namespace Monadial\Siphon;

use Brick\Math\BigDecimal;
use Brick\Math\BigInteger;
use Brick\Math\RoundingMode;
use Closure;
use Monadial\Siphon\Exception\ParseFailure;
use Monadial\Siphon\Exception\UnitNotFound;
use Monadial\Siphon\Parsing\QuantityParser;

/**
 * Abstract base class for all measurable physical quantities.
 *
 * A Quantity pairs an arbitrary-precision numeric value ({@see BigDecimal}) with
 * a unit of measure ({@see UnitOfMeasure}). It is generic over its unit type,
 * ensuring type-safe conversions — e.g., a Length can only be converted to
 * another LengthUnit, never to a MassUnit.
 *
 * All Quantity instances are immutable (`readonly`). Every arithmetic or
 * transformation method returns a new instance, leaving the original unchanged.
 *
 * Quantity implements several functional programming abstractions:
 *
 * - **Functor** via {@see map()} — transform the numeric value while preserving unit
 * - **Applicative Functor** via {@see pure()} and {@see map2()} — lift and combine quantities
 * - **Monad** via {@see flatMap()} — chain computations that may change the unit
 * - **Catamorphism** via {@see fold()} — eliminate the Quantity into an arbitrary type
 *
 * Subclasses represent specific physical dimensions:
 *
 * - {@see \Monadial\Siphon\Unit\Space\Length} — meters, kilometers, miles, etc.
 * - {@see \Monadial\Siphon\Unit\Mass\Mass} — grams, kilograms, pounds, etc.
 * - {@see \Monadial\Siphon\Unit\Temperature\Temperature} — Celsius, Kelvin, Fahrenheit
 * - and many more across mechanics, electrical, information, etc.
 *
 * Usage:
 *
 *     // Create quantities
 *     $length = Length::meters(100);
 *     $mass = Mass::kilograms(2.5);
 *
 *     // Convert between units
 *     $km = $length->scaleTo(Kilometers::make()); // 0.1 km
 *
 *     // Arithmetic
 *     $total = $length->plus(Length::meters(50)); // 150 m
 *
 *     // Functor: transform the value
 *     $doubled = $length->map(fn(BigDecimal $v) => $v->multipliedBy(2)); // 200 m
 *
 *     // Monad: chain with unit change
 *     $result = $length->flatMap(fn(BigDecimal $v, LengthUnit $u) =>
 *         Length::from($v->dividedBy(1000, 10, RoundingMode::HALF_UP), Kilometers::make())
 *     );
 *
 * @template TUoM of UnitOfMeasure
 * @see UnitOfMeasure
 */
abstract readonly class Quantity
{
    /**
     * Create a new Quantity with the given value and unit.
     *
     * This constructor is `final` to ensure that subclass construction is
     * consistent. Use the static factory methods {@see from()}, {@see pure()},
     * or dimension-specific factories (e.g., `Length::meters()`) instead.
     *
     * @param BigDecimal $value The numeric value of the quantity.
     * @param TUoM $uom The unit of measure.
     */
    final public function __construct(
        protected BigDecimal $value,
        protected UnitOfMeasure $uom,
    ) {
    }

    // ---------------------------------------------------------------
    // Static factories
    // ---------------------------------------------------------------

    /**
     * Create a Quantity from a numeric value and a unit of measure.
     *
     * This is the primary factory method. The value is converted to a
     * {@see BigDecimal} for arbitrary-precision arithmetic.
     *
     * Example:
     *
     *     $length = Length::from(100, Meters::make());
     *     $mass = Mass::from('2.5', Kilograms::make());
     *
     * @param BigDecimal|int|float|string $value The numeric value (converted to BigDecimal).
     * @param TUoM $uom The unit of measure.
     * @return static A new Quantity of the calling class.
     */
    public static function from(BigDecimal|int|float|string $value, UnitOfMeasure $uom): static
    {
        return new static(BigDecimal::of($value), $uom);
    }

    /**
     * Create a Quantity by converting a value from one unit to another.
     *
     * Shorthand for `from($value, $from)->scaleTo($to)`.
     *
     * Example:
     *
     *     // Create 1000 meters expressed in kilometers
     *     $km = Length::convert(1000, Meters::make(), Kilometers::make()); // 1 km
     *
     * @param BigDecimal|int|float|string $value The numeric value in the source unit.
     * @param TUoM $from The source unit.
     * @param TUoM $to The target unit.
     * @return static A new Quantity in the target unit.
     */
    public static function convert(
        BigDecimal|int|float|string $value,
        UnitOfMeasure $from,
        UnitOfMeasure $to,
    ): static {
        return self::from($value, $from)->scaleTo($to);
    }

    /**
     * Parse a quantity from a human-readable string like "100 m" or "2.5 kg".
     *
     * Delegates to {@see QuantityParser} which resolves the numeric value
     * and unit symbol against the registered units for the calling class.
     *
     * Example:
     *
     *     $length = Length::parse('100 m'); // Length(100, Meters)
     *     $mass = Mass::parse('2.5 kg'); // Mass(2.5, Kilograms)
     *
     * @return static The parsed Quantity instance.
     * @throws ParseFailure If the input string cannot be parsed.
     * @throws UnitNotFound If the unit symbol is not recognized.
     */
    public static function parse(string $input): static
    {
        $result = QuantityParser::parse($input, static::class);

        $value = $result->get();

        if (is_string($value)) {
            throw new ParseFailure($value);
        }

        return $value;
    }

    /**
     * Lift a value and unit into the Quantity context (Applicative pure / return).
     *
     * This is semantically identical to {@see from()} but named to align with
     * the Applicative Functor pattern. It serves as the unit (return) operation
     * for the Monad instance.
     *
     * Satisfies the Applicative/Monad identity laws:
     *
     *     Quantity::pure($v, $u)->flatMap($f) === $f($v, $u) // left identity
     *     $q->flatMap(fn($v, $u) => Quantity::pure($v, $u)) === $q // right identity
     *
     * @param BigDecimal|int|float|string $value The numeric value.
     * @param TUoM $uom The unit of measure.
     * @return static A new Quantity wrapping the given value and unit.
     */
    public static function pure(BigDecimal|int|float|string $value, UnitOfMeasure $uom): static
    {
        return self::from($value, $uom);
    }

    /**
     * Combine two quantities using a binary function over their numeric values (Applicative lift2).
     *
     * Applies {@see $fn} to the values of both quantities after converting
     * {@see $b} to {@see $a}'s unit. The result is expressed in $a's unit.
     *
     * This is useful for custom combination logic beyond simple addition/subtraction,
     * e.g., computing a weighted average or geometric mean.
     *
     * Example:
     *
     *     $a = Length::meters(10);
     *     $b = Length::meters(20);
     *     $avg = Length::map2($a, $b, fn(BigDecimal $x, BigDecimal $y) =>
     *         $x->plus($y)->dividedBy(2, 10, RoundingMode::HALF_UP)
     *     );
     *     // => Length(15, Meters)
     *
     * @param static $a The first quantity (its unit becomes the result unit).
     * @param static $b The second quantity (converted to $a's unit).
     * @param Closure(BigDecimal, BigDecimal): BigDecimal $fn A binary function combining both numeric values.
     * @return static A new Quantity in $a's unit with the combined value.
     */
    public static function map2(self $a, self $b, Closure $fn): static
    {
        return new static($fn($a->value, $b->scaleTo($a->uom)->value), $a->uom);
    }

    // ---------------------------------------------------------------
    // Accessors
    // ---------------------------------------------------------------

    /**
     * Get the numeric value of this quantity.
     *
     * Returns the raw {@see BigDecimal} value in the quantity's current unit.
     *
     * @return BigDecimal The numeric value.
     */
    public function value(): BigDecimal
    {
        return $this->value;
    }

    /**
     * Format the quantity in scientific notation.
     *
     * Produces a string like "1.000000E+02 m" for 100 meters with default precision.
     *
     * @param int $precision The number of decimal places in the mantissa (default: 6).
     * @return string The scientific notation string with the unit symbol.
     */
    public function toScientificString(int $precision = 6): string
    {
        return sprintf('%.' . $precision . 'E %s', (float) (string) $this->value, $this->uom->symbol());
    }

    /**
     * Get the unit of measure for this quantity.
     *
     * @return TUoM The unit of measure instance.
     */
    public function uom(): UnitOfMeasure
    {
        return $this->uom;
    }

    // ---------------------------------------------------------------
    // Unit conversion
    // ---------------------------------------------------------------

    /**
     * Convert this quantity to a different unit within the same dimension.
     *
     * Uses the unit's factor and offset to perform the conversion with
     * arbitrary-precision arithmetic. The conversion formula handles
     * both linear units (like meters to kilometers) and affine units
     * (like Celsius to Fahrenheit) via the offset mechanism.
     *
     * Conversion formula: `(value + fromOffset) * fromFactor / toFactor - toOffset`
     *
     * Example:
     *
     *     $meters = Length::meters(1000);
     *     $km = $meters->scaleTo(Kilometers::make()); // Length(1, Kilometers)
     *
     * @param TUoM $uom The target unit to convert to.
     * @return static A new Quantity expressed in the target unit.
     */
    public function scaleTo(UnitOfMeasure $uom): static
    {
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
     * Convert to a different unit (Squants-style alias for {@see scaleTo()}).
     *
     * Reads naturally in domain code: `$length->in(Kilometers::make())`.
     *
     * @param TUoM $uom The target unit.
     * @return static A new Quantity in the target unit.
     */
    public function in(UnitOfMeasure $uom): static
    {
        return $this->scaleTo($uom);
    }

    /**
     * Extract the numeric value converted to the given unit (Squants-style).
     *
     * Unlike {@see scaleTo()} which returns a Quantity, this returns just
     * the raw {@see BigDecimal} value. Useful when you need the number
     * for further arithmetic outside the Quantity context.
     *
     * Example:
     *
     *     $meters = Length::kilometers(1)->to(Meters::make()); // BigDecimal(1000)
     *
     * @param TUoM $uom The unit to express the value in.
     * @return BigDecimal The numeric value in the target unit.
     */
    public function to(UnitOfMeasure $uom): BigDecimal
    {
        return $this->scaleTo($uom)->value;
    }

    // ---------------------------------------------------------------
    // Functor / Monad / Catamorphism
    // ---------------------------------------------------------------

    /**
     * Apply a transformation to the numeric value, preserving the unit (Functor fmap).
     *
     * The given function receives the current {@see BigDecimal} value and must
     * return a new BigDecimal. The unit remains unchanged.
     *
     * Satisfies the Functor laws:
     *
     *     $q->map(fn($v) => $v) === $q // identity
     *     $q->map($f)->map($g) === $q->map(fn($v) => $g($f($v))) // composition
     *
     * Example:
     *
     *     $doubled = Length::meters(10)->map(fn(BigDecimal $v) => $v->multipliedBy(2));
     *     // => Length(20, Meters)
     *
     * @param Closure(BigDecimal): BigDecimal $fn A function transforming the numeric value.
     * @return static A new Quantity with the transformed value and the same unit.
     */
    public function map(Closure $fn): static
    {
        return $this->with($fn($this->value), $this->uom);
    }

    /**
     * Chain a computation that may change both value and unit (Monad bind / >>=).
     *
     * The given function receives the current value and unit, and must return
     * a new Quantity of the same dimension. Unlike {@see map()} which can only
     * change the value, flatMap can also change the unit.
     *
     * Satisfies the Monad laws:
     *
     *     Quantity::pure($v, $u)->flatMap($f) === $f($v, $u) // left identity
     *     $q->flatMap(fn($v, $u) => Quantity::pure($v, $u)) === $q // right identity
     *     $q->flatMap($f)->flatMap($g) === $q->flatMap(fn($v, $u) => $f($v, $u)->flatMap($g)) // associativity
     *
     * Example:
     *
     *     // Convert meters to kilometers via flatMap
     *     $km = Length::meters(1000)->flatMap(fn(BigDecimal $v, LengthUnit $u) =>
     *         Length::from($v->dividedBy(1000, 10, RoundingMode::HALF_UP), Kilometers::make())
     *     );
     *     // => Length(1, Kilometers)
     *
     * @param Closure(BigDecimal, TUoM): static $fn A function producing a new Quantity.
     * @return static The Quantity returned by {@see $fn}.
     */
    public function flatMap(Closure $fn): static
    {
        return $fn($this->value, $this->uom);
    }

    /**
     * Eliminate the Quantity by applying a function to its components (catamorphism / destructor).
     *
     * Extracts the value and unit from the Quantity context and passes them
     * to the given function, returning its result. This is the universal
     * way to "unwrap" a Quantity into any other type.
     *
     * Example:
     *
     *     $label = Length::meters(42)->fold(fn(BigDecimal $v, LengthUnit $u) =>
     *         $v . ' ' . $u->symbol()
     *     );
     *     // => "42 m"
     *
     * @template R
     * @param Closure(BigDecimal, TUoM): R $fn A function that consumes value and unit.
     * @return R The value produced by {@see $fn}.
     */
    public function fold(Closure $fn): mixed
    {
        return $fn($this->value, $this->uom);
    }

    // ---------------------------------------------------------------
    // Arithmetic (same dimension)
    // ---------------------------------------------------------------

    /**
     * Add another quantity of the same dimension.
     *
     * The other quantity is first converted to this quantity's unit before
     * addition, so cross-unit arithmetic is supported.
     *
     * Example:
     *
     *     Length::kilometers(1)->plus(Length::meters(500)); // Length(1.5, Kilometers)
     *
     * @param static $that The quantity to add (automatically converted to this unit).
     * @return static A new Quantity with the summed value in this quantity's unit.
     */
    public function plus(self $that): static
    {
        return $this->with(
            $this->value->plus($that->scaleTo($this->uom)->value),
            $this->uom,
        );
    }

    /**
     * Subtract another quantity of the same dimension.
     *
     * The other quantity is first converted to this quantity's unit before
     * subtraction, so cross-unit arithmetic is supported.
     *
     * Example:
     *
     *     Length::meters(1000)->minus(Length::kilometers(1)); // Length(0, Meters)
     *
     * @param static $that The quantity to subtract (automatically converted to this unit).
     * @return static A new Quantity with the difference in this quantity's unit.
     */
    public function minus(self $that): static
    {
        return $this->with(
            $this->value->minus($that->scaleTo($this->uom)->value),
            $this->uom,
        );
    }

    /**
     * Multiply the quantity's value by a dimensionless scalar.
     *
     * The unit remains unchanged — only the numeric value is scaled.
     *
     * Example:
     *
     *     Length::meters(10)->times(3); // Length(30, Meters)
     *     Length::meters(10)->times('2.5'); // Length(25.0, Meters)
     *
     * @param BigDecimal|BigInteger|int|float|string $scalar The scalar multiplier.
     * @return static A new Quantity with the scaled value.
     */
    public function times(BigDecimal|BigInteger|int|float|string $scalar): static
    {
        return $this->with(
            $this->value->multipliedBy($scalar),
            $this->uom,
        );
    }

    /**
     * Divide the quantity's value by a dimensionless scalar.
     *
     * The unit remains unchanged — only the numeric value is divided.
     * Uses HALF_UP rounding at the specified scale.
     *
     * Example:
     *
     *     Length::meters(100)->dividedBy(4); // Length(25, Meters)
     *     Length::meters(10)->dividedBy('3'); // Length(3.333..., Meters)
     *
     * @param BigDecimal|BigInteger|int|float|string $scalar The scalar divisor.
     * @param int $scale The decimal scale for rounding (default: 20).
     * @return static A new Quantity with the divided value.
     */
    public function dividedBy(BigDecimal|BigInteger|int|float|string $scalar, int $scale = 20): static
    {
        return $this->with(
            $this->value->dividedBy($scalar, $scale, RoundingMode::HALF_UP),
            $this->uom,
        );
    }

    /**
     * Negate the quantity's value (multiply by -1).
     *
     * Example:
     *
     *     Length::meters(42)->negate(); // Length(-42, Meters)
     *
     * @return static A new Quantity with the negated value.
     */
    public function negate(): static
    {
        return $this->with($this->value->negated(), $this->uom);
    }

    /**
     * Return the absolute value of this quantity.
     *
     * Example:
     *
     *     Length::meters(-42)->abs(); // Length(42, Meters)
     *
     * @return static A new Quantity with the absolute value.
     */
    public function abs(): static
    {
        return $this->with($this->value->abs(), $this->uom);
    }

    // ---------------------------------------------------------------
    // Comparisons
    // ---------------------------------------------------------------

    /**
     * Check whether two quantities represent the same physical magnitude.
     *
     * Both quantities are normalized to their base unit values before
     * comparison, so quantities in different units can be equal.
     *
     * Example:
     *
     *     Length::meters(1000)->isEqualTo(Length::kilometers(1)); // true
     *
     * @param static $that The quantity to compare against.
     * @return bool True if both represent the same physical magnitude.
     */
    public function isEqualTo(self $that): bool
    {
        return $this->toBaseValue()->isEqualTo($that->toBaseValue());
    }

    /**
     * Check whether this quantity is strictly greater than another.
     *
     * Both quantities are normalized to base units before comparison.
     *
     * @param static $that The quantity to compare against.
     * @return bool True if this quantity is greater.
     */
    public function isGreaterThan(self $that): bool
    {
        return $this->toBaseValue()->isGreaterThan($that->toBaseValue());
    }

    /**
     * Check whether this quantity is strictly less than another.
     *
     * Both quantities are normalized to base units before comparison.
     *
     * @param static $that The quantity to compare against.
     * @return bool True if this quantity is less.
     */
    public function isLessThan(self $that): bool
    {
        return $this->toBaseValue()->isLessThan($that->toBaseValue());
    }

    /**
     * Check whether this quantity is greater than or equal to another.
     *
     * Both quantities are normalized to base units before comparison.
     *
     * @param static $that The quantity to compare against.
     * @return bool True if this quantity is greater than or equal.
     */
    public function isGreaterThanOrEqualTo(self $that): bool
    {
        return $this->toBaseValue()->isGreaterThanOrEqualTo($that->toBaseValue());
    }

    /**
     * Check whether this quantity is less than or equal to another.
     *
     * Both quantities are normalized to base units before comparison.
     *
     * @param static $that The quantity to compare against.
     * @return bool True if this quantity is less than or equal.
     */
    public function isLessThanOrEqualTo(self $that): bool
    {
        return $this->toBaseValue()->isLessThanOrEqualTo($that->toBaseValue());
    }

    /**
     * Check approximate equality within a given tolerance.
     *
     * Computes the absolute difference between the two quantities
     * (in base units) and checks whether it falls within the tolerance.
     *
     * Example:
     *
     *     $a = Length::kilometers(1);
     *     $b = Length::meters(1001);
     *     $a->approx($b, Length::meters(2)); // true (difference is 1 m, within 2 m)
     *
     * @param static $that The quantity to compare against.
     * @param static $tolerance The maximum allowed difference.
     * @return bool True if the absolute difference is within the tolerance.
     */
    public function approx(self $that, self $tolerance): bool
    {
        $diff = $this->toBaseValue()->minus($that->toBaseValue())->abs();

        return $diff->isLessThanOrEqualTo($tolerance->toBaseValue());
    }

    /**
     * Return the minimum of this quantity and one or more others.
     *
     * The result is expressed in this quantity's unit. If no arguments
     * are provided, returns this quantity unchanged.
     *
     * Example:
     *
     *     Length::meters(100)->min(Length::meters(50), Length::meters(200)); // 50 m
     *
     * @param static ...$others One or more quantities to compare.
     * @return static The smallest quantity, expressed in this quantity's unit.
     */
    public function min(self ...$others): static
    {
        $result = $this;
        foreach ($others as $other) {
            if (!$other->isLessThan($result)) {
                continue;
            }

            $result = $other->scaleTo($this->uom);
        }

        return $result;
    }

    /**
     * Return the maximum of this quantity and one or more others.
     *
     * The result is expressed in this quantity's unit. If no arguments
     * are provided, returns this quantity unchanged.
     *
     * Example:
     *
     *     Length::meters(100)->max(Length::meters(50), Length::meters(200)); // 200 m
     *
     * @param static ...$others One or more quantities to compare.
     * @return static The largest quantity, expressed in this quantity's unit.
     */
    public function max(self ...$others): static
    {
        $result = $this;
        foreach ($others as $other) {
            if (!$other->isGreaterThan($result)) {
                continue;
            }

            $result = $other->scaleTo($this->uom);
        }

        return $result;
    }

    // ---------------------------------------------------------------
    // Internal
    // ---------------------------------------------------------------

    /**
     * Normalize the value to base units using the unit's factor and offset.
     *
     * The formula `(value + offset) * factor` maps any unit-specific value
     * to its base-unit equivalent, enabling cross-unit comparisons.
     *
     * @return BigDecimal The value normalized to the dimension's base unit.
     */
    protected function toBaseValue(): BigDecimal
    {
        return $this->value
            ->plus($this->uom->offset())
            ->multipliedBy($this->uom->factor());
    }

    /**
     * Create a new instance of the same Quantity subclass with a different value and/or unit.
     *
     * This is the internal constructor delegate used by all transformation
     * methods to preserve the concrete Quantity subclass type.
     *
     * @param BigDecimal $value The new numeric value.
     * @param TUoM $uom The new unit of measure.
     * @return static A new Quantity of the same concrete type.
     */
    private function with(BigDecimal $value, UnitOfMeasure $uom): static
    {
        return new static($value, $uom);
    }

    /**
     * Return a human-readable string representation of the quantity.
     *
     * Format: "{value} {symbol}", e.g. "100 m", "2.5 kg".
     *
     * @return string The formatted quantity string.
     */
    public function __toString(): string
    {
        return (string) $this->value . ' ' . $this->uom->symbol();
    }
}
