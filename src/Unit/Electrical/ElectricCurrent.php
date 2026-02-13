<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Electrical\ElectricCurrent\Amperes;
use Monadial\Siphon\Unit\Electrical\ElectricCurrent\Kiloamperes;
use Monadial\Siphon\Unit\Electrical\ElectricCurrent\Microamperes;
use Monadial\Siphon\Unit\Electrical\ElectricCurrent\Milliamperes;
use Monadial\Siphon\Unit\Time\Time;

/**
 * Electric current — the rate of flow of electric charge past a point.
 *
 * SI base unit: ampere (A). Dimension: A (one of the seven SI base dimensions).
 *
 * One ampere is defined by fixing the elementary charge e to 1.602176634 * 10^-19 C.
 * Ohm's law relates current to voltage and resistance: I = V / R.
 *
 * Available units: {@see Microamperes}, {@see Milliamperes}, {@see Amperes},
 * {@see Kiloamperes}.
 *
 * Usage:
 *
 *     $i = ElectricCurrent::amperes(5);
 *     $inMilliamps = $i->toMilliamperes(); // 5000 mA
 *
 * @template-extends Quantity<ElectricCurrentUnit>
 */
final readonly class ElectricCurrent extends Quantity
{
    /** Static factory methods for creating ElectricCurrent in any supported unit. */
    // BEGIN_TYPED_FACTORIES
    public static function amperes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Amperes::make());
    }

    public static function ampere(BigDecimal|int|float|string $value): self
    {
        return self::amperes($value);
    }

    public static function kiloamperes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kiloamperes::make());
    }

    public static function kiloampere(BigDecimal|int|float|string $value): self
    {
        return self::kiloamperes($value);
    }

    public static function microamperes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Microamperes::make());
    }

    public static function microampere(BigDecimal|int|float|string $value): self
    {
        return self::microamperes($value);
    }

    public static function milliamperes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Milliamperes::make());
    }

    public static function milliampere(BigDecimal|int|float|string $value): self
    {
        return self::milliamperes($value);
    }

    // END_TYPED_FACTORIES

    /** Convert this electric current to the specified unit via {@see scaleTo()}. */
    public function toMicroamperes(): self
    {
        return $this->scaleTo(Microamperes::make());
    }

    public function toMilliamperes(): self
    {
        return $this->scaleTo(Milliamperes::make());
    }

    public function toAmperes(): self
    {
        return $this->scaleTo(Amperes::make());
    }

    public function toKiloamperes(): self
    {
        return $this->scaleTo(Kiloamperes::make());
    }

    // ---------------------------------------------------------------
    // Cross-dimensional operations
    // ---------------------------------------------------------------

    /**
     * Compute voltage: V = I * R (Ohm's law, current times resistance).
     *
     * @param ElectricalResistance $resistance the electrical resistance
     * @return ElectricPotential the resulting voltage in volts
     */
    public function timesResistance(ElectricalResistance $resistance): ElectricPotential
    {
        $base = $this->toBaseValue()->multipliedBy($resistance->toBaseValue());

        return ElectricPotential::volts($base);
    }

    /**
     * Compute electric charge: Q = I * t (current times time).
     *
     * @param Time $time the elapsed time
     * @return ElectricCharge the accumulated charge in coulombs
     */
    public function timesTime(Time $time): ElectricCharge
    {
        $base = $this->toBaseValue()->multipliedBy($time->toBaseValue());

        return ElectricCharge::coulombs($base);
    }
}
