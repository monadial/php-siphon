<?php

declare(strict_types=1);

namespace Monadial\Siphon;

use Brick\Math\BigDecimal;
use Brick\Math\BigNumber;
use Fp\Collections\ArrayList;
use Stringable;

/**
 * A Unit of Measure is used to define the scale of a quantity in a specific domain.
 *
 * @see https://en.wikipedia.org/wiki/Unit_of_measurement
 * @psalm-consistent-constructor
 */
abstract readonly class UnitOfMeasure
{
    public function __construct()
    {
    }

    abstract public static function apply(BigDecimal $value): Quantity;

    abstract public static function fromString(Stringable|string $value): Quantity;

    abstract public static function fromInt(int $value): Quantity;

    public static function make(): static
    {
        return new static();
    }

    /**
     * Returns supported symbols for the unit of measure.
     *
     * @return ArrayList<string>
     */
    abstract public function symbols(): ArrayList;

    /**
     * Returns the factor of the unit of measure.
     */
    abstract public function factor(): BigDecimal;

    public function equals(self $that): bool
    {
        return $that instanceof $this;
    }
}
