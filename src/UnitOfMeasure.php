<?php

declare(strict_types=1);

namespace Monadial\Siphon;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Exception\UnitNotFound;
use WeakReference;

/**
 * Abstract base class for all units of measure in the SI system.
 *
 * Each concrete unit (e.g., Meters, Kilograms, Seconds) extends this class
 * and provides its conversion factor relative to the dimension's base unit.
 * Units are flyweight singletons obtained via {@see make()} — each unit class
 * has at most one live instance at any time (garbage-collectible via WeakReference).
 *
 * The conversion model supports both linear and affine transformations:
 *
 * - **Linear units** (most units): defined by a {@see factor()} only.
 *   Base value = value * factor
 *
 * - **Affine units** (e.g., temperature): defined by both {@see factor()} and {@see offset()}.
 *   Base value = (value + offset) * factor
 *
 * Convention: Always use {@see equals()} for unit comparison, never `===`,
 * because WeakReference-based flyweights may be garbage-collected and recreated.
 *
 * Usage:
 *
 *     $meters = Meters::make(); // get the singleton Meters instance
 *     $factor = $meters->factor(); // BigDecimal conversion factor
 *     $symbol = $meters->symbol(); // "m"
 *     $name = $meters->name(); // "meters"
 *
 * @see Quantity
 */
abstract readonly class UnitOfMeasure
{
    /**
     * Protected constructor — units are instantiated only through {@see make()}.
     */
    final protected function __construct()
    {
    }

    // ---------------------------------------------------------------
    // Flyweight factory
    // ---------------------------------------------------------------

    /**
     * Get the singleton instance of this unit (flyweight pattern).
     *
     * Uses {@see WeakReference} internally so instances may be garbage-collected
     * when no strong references remain. A new instance is transparently created
     * on the next call if the previous one was collected.
     *
     * Example:
     *
     *     $meters = Meters::make();
     *     $also = Meters::make();
     *     // $meters and $also are the same instance (while both are alive)
     *
     * @return static The singleton instance of the calling unit class.
     */
    public static function make(): static
    {
        /** @var array<class-string<static>, WeakReference<static>> $instances */
        static $instances = [];

        $ref = $instances[static::class] ?? null;

        $instance = $ref?->get();

        if ($instance !== null) {
            return $instance;
        }

        $instance = new static();

        $instances[static::class] = WeakReference::create($instance);

        return $instance;
    }

    /**
     * Create a Quantity of this unit's dimension from a numeric value.
     *
     * Infers the Quantity subclass from the unit's namespace. For example,
     * `Meters::from(100)` infers that Meters belongs to the Length dimension
     * and creates a `Length(100, Meters)`.
     *
     * Example:
     *
     *     $length = Meters::from(100); // Length(100, Meters)
     *     $mass = Kilograms::from(2.5); // Mass(2.5, Kilograms)
     *
     * @param BigDecimal|int|float|string $value The numeric value.
     * @return Quantity<UnitOfMeasure> A Quantity in this unit.
     * @throws UnitNotFound If the Quantity class cannot be inferred from the unit's namespace.
     */
    public static function from(BigDecimal|int|float|string $value): Quantity
    {
        $quantityClass = substr(static::class, 0, (int) strrpos(static::class, '\\'));

        if ($quantityClass === '' || !is_a($quantityClass, Quantity::class, true)) {
            throw new UnitNotFound(sprintf('Unable to infer quantity class for unit %s', static::class));
        }

        return new $quantityClass(BigDecimal::of($value), static::make());
    }

    // ---------------------------------------------------------------
    // Conversion parameters
    // ---------------------------------------------------------------

    /**
     * Get the conversion factor relative to the dimension's base unit.
     *
     * For linear units, this is the multiplier to convert from this unit
     * to the base unit. For example, Kilometers has factor 1000 (since
     * 1 km = 1000 m, where meters is the base unit for length).
     *
     * @return BigDecimal The conversion factor.
     */
    abstract public function factor(): BigDecimal;

    /**
     * Get the unit's display symbol (e.g., "m", "kg", "s", "K").
     *
     * Used in string representations of quantities and prices.
     *
     * @return string The unit symbol.
     */
    abstract public function symbol(): string;

    /**
     * Get the additive offset for affine unit conversions.
     *
     * Most units return zero (pure multiplicative conversion). Temperature
     * units like Celsius and Fahrenheit override this to account for their
     * shifted zero points relative to Kelvin.
     *
     * @return BigDecimal The additive offset (default: zero).
     */
    public function offset(): BigDecimal
    {
        return BigDecimal::zero();
    }

    /**
     * Get a human-readable name for this unit derived from the class name.
     *
     * Converts the short class name from PascalCase to lowercase words.
     * For example, `SquareMeters` becomes "square meters".
     *
     * @return string The human-readable unit name.
     */
    public function name(): string
    {
        $class = static::class;
        $shortName = substr($class, (int) strrpos($class, '\\') + 1);
        $spaced = preg_replace('/(?<!^)([A-Z])/', ' $1', $shortName) ?? $shortName;

        return strtolower($spaced);
    }

    // ---------------------------------------------------------------
    // Equality
    // ---------------------------------------------------------------

    /**
     * Check whether two unit instances represent the same unit.
     *
     * Compares by class identity rather than instance identity (`===`),
     * because the flyweight instances may be garbage-collected and recreated.
     *
     * @param UnitOfMeasure $that The unit to compare against.
     * @return bool True if both are instances of the same unit class.
     */
    // phpcs:ignore SlevomatCodingStandard.Classes.RequireSelfReference.RequiredSelfReference
    public function equals(self $that): bool
    {
        // phpcs:ignore SlevomatCodingStandard.Classes.RequireSelfReference.RequiredSelfReference
        return $that::class === static::class;
    }
}
