<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Electrical\ElectricPotential\Kilovolts;
use Monadial\Siphon\Unit\Electrical\ElectricPotential\Megavolts;
use Monadial\Siphon\Unit\Electrical\ElectricPotential\Microvolts;
use Monadial\Siphon\Unit\Electrical\ElectricPotential\Millivolts;
use Monadial\Siphon\Unit\Electrical\ElectricPotential\Volts;
use Monadial\Siphon\Unit\Mechanics\Power;

/**
 * Electric potential (voltage) — work done per unit charge to move charge between two points.
 *
 * SI base unit: volt (V). Dimension: kg * m^2 * s^-3 * A^-1.
 *
 * One volt is the potential difference that moves one coulomb of charge
 * with one joule of energy. Ohm's law: V = I * R. Power: P = V * I.
 *
 * Available units: {@see Microvolts}, {@see Millivolts}, {@see Volts},
 * {@see Kilovolts}, {@see Megavolts}.
 *
 * Usage:
 *
 *     $v = ElectricPotential::volts(230);
 *     $inKv = $v->toKilovolts(); // 0.23 kV
 *
 * @template-extends Quantity<ElectricPotentialUnit>
 */
final readonly class ElectricPotential extends Quantity
{
    /** Static factory methods for creating ElectricPotential in any supported unit. */
    // BEGIN_TYPED_FACTORIES
    public static function kilovolts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilovolts::make());
    }

    public static function kilovolt(BigDecimal|int|float|string $value): self
    {
        return self::kilovolts($value);
    }

    public static function megavolts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Megavolts::make());
    }

    public static function megavolt(BigDecimal|int|float|string $value): self
    {
        return self::megavolts($value);
    }

    public static function microvolts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Microvolts::make());
    }

    public static function microvolt(BigDecimal|int|float|string $value): self
    {
        return self::microvolts($value);
    }

    public static function millivolts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Millivolts::make());
    }

    public static function millivolt(BigDecimal|int|float|string $value): self
    {
        return self::millivolts($value);
    }

    public static function volts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Volts::make());
    }

    public static function volt(BigDecimal|int|float|string $value): self
    {
        return self::volts($value);
    }

    // END_TYPED_FACTORIES

    /** Convert this electric potential to the specified unit via {@see scaleTo()}. */
    public function toVolts(): self
    {
        return $this->scaleTo(Volts::make());
    }

    public function toMicrovolts(): self
    {
        return $this->scaleTo(Microvolts::make());
    }

    public function toMillivolts(): self
    {
        return $this->scaleTo(Millivolts::make());
    }

    public function toKilovolts(): self
    {
        return $this->scaleTo(Kilovolts::make());
    }

    public function toMegavolts(): self
    {
        return $this->scaleTo(Megavolts::make());
    }

    // ---------------------------------------------------------------
    // Cross-dimensional operations
    // ---------------------------------------------------------------

    /**
     * Compute power: P = V * I (voltage times current).
     *
     * @param ElectricCurrent $current the electric current
     * @return Power the resulting power in watts
     */
    public function timesCurrent(ElectricCurrent $current): Power
    {
        $base = $this->toBaseValue()->multipliedBy($current->toBaseValue());

        return Power::watts($base);
    }

    /**
     * Compute resistance: R = V / I (Ohm's law, voltage divided by current).
     *
     * @param ElectricCurrent $current the electric current
     * @return ElectricalResistance the resulting resistance in ohms
     */
    public function dividedByCurrent(ElectricCurrent $current): ElectricalResistance
    {
        $base = $this->toBaseValue()->dividedBy($current->toBaseValue(), 20, RoundingMode::HALF_UP);

        return ElectricalResistance::ohms($base);
    }

    /**
     * Compute current: I = V / R (Ohm's law, voltage divided by resistance).
     *
     * @param ElectricalResistance $resistance the electrical resistance
     * @return ElectricCurrent the resulting current in amperes
     */
    public function dividedByResistance(ElectricalResistance $resistance): ElectricCurrent
    {
        $base = $this->toBaseValue()->dividedBy($resistance->toBaseValue(), 20, RoundingMode::HALF_UP);

        return ElectricCurrent::amperes($base);
    }
}
