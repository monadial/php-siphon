<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\AmpereHours;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\Coulombs;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\Microcoulombs;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\MilliampereHours;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\Millicoulombs;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\Nanocoulombs;
use Monadial\Siphon\Unit\Electrical\ElectricCharge\Picocoulombs;
use Monadial\Siphon\Unit\Time\Time;

/**
 * Electric charge — the amount of electricity transported by a current.
 *
 * SI base unit: coulomb (C). Dimension: A * s.
 *
 * One coulomb is the charge transported by a constant current of one ampere
 * in one second. The relationship Q = I * t connects charge, current, and time.
 *
 * Available units: {@see Picocoulombs}, {@see Nanocoulombs}, {@see Microcoulombs},
 * {@see Millicoulombs}, {@see Coulombs}, {@see MilliampereHours}, {@see AmpereHours}.
 *
 * Usage:
 *
 *     $q = ElectricCharge::coulombs(3600);
 *     $inAh = $q->toAmpereHours(); // 1 Ah
 *
 * @template-extends Quantity<ElectricChargeUnit>
 */
final readonly class ElectricCharge extends Quantity
{
    /** Static factory methods for creating ElectricCharge in any supported unit. */
    // BEGIN_TYPED_FACTORIES
    public static function ampereHours(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), AmpereHours::make());
    }

    public static function ampereHour(BigDecimal|int|float|string $value): self
    {
        return self::ampereHours($value);
    }

    public static function coulombs(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Coulombs::make());
    }

    public static function coulomb(BigDecimal|int|float|string $value): self
    {
        return self::coulombs($value);
    }

    public static function microcoulombs(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Microcoulombs::make());
    }

    public static function microcoulomb(BigDecimal|int|float|string $value): self
    {
        return self::microcoulombs($value);
    }

    public static function milliampereHours(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), MilliampereHours::make());
    }

    public static function milliampereHour(BigDecimal|int|float|string $value): self
    {
        return self::milliampereHours($value);
    }

    public static function millicoulombs(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Millicoulombs::make());
    }

    public static function millicoulomb(BigDecimal|int|float|string $value): self
    {
        return self::millicoulombs($value);
    }

    public static function nanocoulombs(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Nanocoulombs::make());
    }

    public static function nanocoulomb(BigDecimal|int|float|string $value): self
    {
        return self::nanocoulombs($value);
    }

    public static function picocoulombs(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Picocoulombs::make());
    }

    public static function picocoulomb(BigDecimal|int|float|string $value): self
    {
        return self::picocoulombs($value);
    }

    // END_TYPED_FACTORIES

    /** Convert this electric charge to the specified unit via {@see scaleTo()}. */
    public function toCoulombs(): self
    {
        return $this->scaleTo(Coulombs::make());
    }

    public function toMillicoulombs(): self
    {
        return $this->scaleTo(Millicoulombs::make());
    }

    public function toMicrocoulombs(): self
    {
        return $this->scaleTo(Microcoulombs::make());
    }

    public function toNanocoulombs(): self
    {
        return $this->scaleTo(Nanocoulombs::make());
    }

    public function toPicocoulombs(): self
    {
        return $this->scaleTo(Picocoulombs::make());
    }

    public function toAmpereHours(): self
    {
        return $this->scaleTo(AmpereHours::make());
    }

    public function toMilliampereHours(): self
    {
        return $this->scaleTo(MilliampereHours::make());
    }

    /**
     * Compute electric current: I = Q / t (charge divided by time).
     *
     * @param Time $time the elapsed time
     * @return ElectricCurrent the resulting current in amperes
     */
    public function dividedByTime(Time $time): ElectricCurrent
    {
        $base = $this->toBaseValue()->dividedBy($time->toBaseValue(), 20, RoundingMode::HALF_UP);

        return ElectricCurrent::amperes($base);
    }

    /**
     * Compute time: t = Q / I (charge divided by current).
     *
     * @param ElectricCurrent $current the electric current
     * @return Time the elapsed time in seconds
     */
    public function dividedByCurrent(ElectricCurrent $current): Time
    {
        $base = $this->toBaseValue()->dividedBy($current->toBaseValue(), 20, RoundingMode::HALF_UP);

        return Time::seconds($base);
    }

    /**
     * Compute voltage: V = Q / C (charge divided by capacitance).
     *
     * @param Capacitance $capacitance the capacitance of the capacitor
     * @return ElectricPotential the resulting voltage in volts
     */
    public function dividedByCapacitance(Capacitance $capacitance): ElectricPotential
    {
        $base = $this->toBaseValue()->dividedBy($capacitance->toBaseValue(), 20, RoundingMode::HALF_UP);

        return ElectricPotential::volts($base);
    }
}
