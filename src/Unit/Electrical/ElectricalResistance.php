<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Gigohms;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Kilohms;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Megohms;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Microhms;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Milliohms;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Nanohms;
use Monadial\Siphon\Unit\Electrical\ElectricalResistance\Ohms;

/**
 * Electrical resistance — the opposition to electric current flow in a conductor.
 *
 * SI base unit: ohm (Ohm). Dimension: kg * m^2 * s^-3 * A^-2.
 *
 * One ohm is the resistance between two points when a potential difference of
 * one volt produces a current of one ampere. Ohm's law: R = V / I.
 *
 * Available units: {@see Nanohms}, {@see Microhms}, {@see Milliohms},
 * {@see Ohms}, {@see Kilohms}, {@see Megohms}, {@see Gigohms}.
 *
 * Usage:
 *
 *     $r = ElectricalResistance::kilohms(4.7);
 *     $inOhms = $r->toOhms(); // 4700 Ohm
 *
 * @template-extends Quantity<ElectricalResistanceUnit>
 */
final readonly class ElectricalResistance extends Quantity
{
    /** Static factory methods for creating ElectricalResistance in any supported unit. */
    // BEGIN_TYPED_FACTORIES
    public static function gigohms(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Gigohms::make());
    }

    public static function gigohm(BigDecimal|int|float|string $value): self
    {
        return self::gigohms($value);
    }

    public static function kilohms(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilohms::make());
    }

    public static function kilohm(BigDecimal|int|float|string $value): self
    {
        return self::kilohms($value);
    }

    public static function megohms(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Megohms::make());
    }

    public static function megohm(BigDecimal|int|float|string $value): self
    {
        return self::megohms($value);
    }

    public static function microhms(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Microhms::make());
    }

    public static function microhm(BigDecimal|int|float|string $value): self
    {
        return self::microhms($value);
    }

    public static function milliohms(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Milliohms::make());
    }

    public static function milliohm(BigDecimal|int|float|string $value): self
    {
        return self::milliohms($value);
    }

    public static function nanohms(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Nanohms::make());
    }

    public static function nanohm(BigDecimal|int|float|string $value): self
    {
        return self::nanohms($value);
    }

    public static function ohms(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Ohms::make());
    }

    public static function ohm(BigDecimal|int|float|string $value): self
    {
        return self::ohms($value);
    }

    // END_TYPED_FACTORIES

    /** Convert this electrical resistance to the specified unit via {@see scaleTo()}. */
    public function toOhms(): self
    {
        return $this->scaleTo(Ohms::make());
    }

    public function toNanohms(): self
    {
        return $this->scaleTo(Nanohms::make());
    }

    public function toMicrohms(): self
    {
        return $this->scaleTo(Microhms::make());
    }

    public function toMilliohms(): self
    {
        return $this->scaleTo(Milliohms::make());
    }

    public function toKilohms(): self
    {
        return $this->scaleTo(Kilohms::make());
    }

    public function toMegohms(): self
    {
        return $this->scaleTo(Megohms::make());
    }

    public function toGigohms(): self
    {
        return $this->scaleTo(Gigohms::make());
    }

    /**
     * Compute voltage: V = R * I (Ohm's law, resistance times current).
     *
     * @param ElectricCurrent $current the electric current
     * @return ElectricPotential the resulting voltage in volts
     */
    public function timesCurrent(ElectricCurrent $current): ElectricPotential
    {
        $base = $this->toBaseValue()->multipliedBy($current->toBaseValue());

        return ElectricPotential::volts($base);
    }
}
