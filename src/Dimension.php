<?php

declare(strict_types=1);

namespace Monadial\Siphon;

use Brick\Math\BigDecimal;
use Fp\Collections\ArrayList;
use Fp\Collections\HashMap;
use Fp\Functional\Option\Option;
use Stringable;

use function Fp\Callable\ctor;

/**
 * @template T of Quantity
 */
abstract readonly class Dimension
{
    /**
     * @return Option<T>
     */
    abstract public static function fromString(Stringable|string $input): Option;

    /**
     * @return T
     */
    public static function apply(BigDecimal $value, UnitOfMeasure $uom): Quantity
    {
        return ctor(static::quantity())($value, $uom);
    }

    abstract protected static function baseUnit(): UnitOfMeasure;

    /**
     * @return ArrayList<UnitOfMeasure>
     */
    abstract protected static function units(): ArrayList;

    abstract protected static function regex(): string;

    /**
     * @return class-string<T>
     */
    abstract protected static function quantity(): string;

    protected static function unitIndex(): HashMap
    {
        return static::units()
            ->flatMap(static fn (UnitOfMeasure $unit) => $unit->symbols()
                ->map(static fn (string $symbol) => new DimensionPair($symbol, $unit)))
            ->reindex(static fn (DimensionPair $pair) => $pair->symbol)
            ->map(static fn (DimensionPair $pair) => $pair->oum);
    }
}
