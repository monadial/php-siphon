<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Electrical\ElectricCurrent;
use Monadial\Siphon\Unit\Electrical\ElectricPotential;
use Monadial\Siphon\Unit\Mechanics\Energy\WattHours;
use Monadial\Siphon\Unit\Mechanics\Power\BtusPerHour;
use Monadial\Siphon\Unit\Mechanics\Power\Gigawatts;
use Monadial\Siphon\Unit\Mechanics\Power\Horsepower;
use Monadial\Siphon\Unit\Mechanics\Power\Kilowatts;
use Monadial\Siphon\Unit\Mechanics\Power\Megawatts;
use Monadial\Siphon\Unit\Mechanics\Power\Milliwatts;
use Monadial\Siphon\Unit\Mechanics\Power\Watts;
use Monadial\Siphon\Unit\Motion\Velocity;
use Monadial\Siphon\Unit\Time\Time;

/**
 * Power measures the rate at which energy is transferred or converted.
 *
 * The SI unit of power is the watt (W). Power is a derived quantity with dimension
 * M*L^2*T^-3, equivalent to J/s or kg*m^2/s^3. Power quantifies how quickly work
 * is performed, from electrical circuits to mechanical engines.
 *
 * Available units: Milliwatts (10^-3), Watts (base, factor 1), Kilowatts (10^3),
 * Megawatts (10^6), Gigawatts (10^9), Horsepower (745.69987), BtusPerHour (0.29307107).
 *
 * Cross-dimensional operations:
 * - Power * Time = Energy (E = P*t)
 * - Power / Current = ElectricPotential (V = P/I)
 * - Power / Potential = ElectricCurrent (I = P/V)
 * - Power / Force = Velocity (v = P/F)
 * - Power / Velocity = Force (F = P/v)
 *
 * Example usage:
 * ```
 * $power = Power::kilowatts(5);
 * $energy = $power->timesTime(Time::hours(3));
 * $wattHours = $power->toWattHours();
 * ```
 *
 * @see PowerUnit for the abstract unit base class
 * @template-extends Quantity<PowerUnit>
 */
final readonly class Power extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function btusPerHour(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), BtusPerHour::make());
    }

    public static function gigawatts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Gigawatts::make());
    }

    public static function gigawatt(BigDecimal|int|float|string $value): self
    {
        return self::gigawatts($value);
    }

    public static function horsepower(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Horsepower::make());
    }

    public static function kilowatts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilowatts::make());
    }

    public static function kilowatt(BigDecimal|int|float|string $value): self
    {
        return self::kilowatts($value);
    }

    public static function megawatts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Megawatts::make());
    }

    public static function megawatt(BigDecimal|int|float|string $value): self
    {
        return self::megawatts($value);
    }

    public static function milliwatts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Milliwatts::make());
    }

    public static function milliwatt(BigDecimal|int|float|string $value): self
    {
        return self::milliwatts($value);
    }

    public static function watts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Watts::make());
    }

    public static function watt(BigDecimal|int|float|string $value): self
    {
        return self::watts($value);
    }

    // END_TYPED_FACTORIES
    public function toWattHours(?Time $duration = null): Energy
    {
        $duration ??= Time::hours(1);

        return $this->timesTime($duration)->scaleTo(WattHours::make());
    }

    public function toWatts(): self
    {
        return $this->scaleTo(Watts::make());
    }

    public function toMilliwatts(): self
    {
        return $this->scaleTo(Milliwatts::make());
    }

    public function toKilowatts(): self
    {
        return $this->scaleTo(Kilowatts::make());
    }

    public function toMegawatts(): self
    {
        return $this->scaleTo(Megawatts::make());
    }

    public function toGigawatts(): self
    {
        return $this->scaleTo(Gigawatts::make());
    }

    public function toHorsepower(): self
    {
        return $this->scaleTo(Horsepower::make());
    }

    public function toBtusPerHour(): self
    {
        return $this->scaleTo(BtusPerHour::make());
    }

    public function timesTime(Time $time): Energy
    {
        $base = $this->toBaseValue()->multipliedBy($time->toBaseValue());

        return Energy::joules($base);
    }

    public function dividedByCurrent(ElectricCurrent $current): ElectricPotential
    {
        $base = $this->toBaseValue()->dividedBy($current->toBaseValue(), 20, RoundingMode::HALF_UP);

        return ElectricPotential::volts($base);
    }

    public function dividedByPotential(ElectricPotential $potential): ElectricCurrent
    {
        $base = $this->toBaseValue()->dividedBy($potential->toBaseValue(), 20, RoundingMode::HALF_UP);

        return ElectricCurrent::amperes($base);
    }

    public function dividedByForce(Force $force): Velocity
    {
        $base = $this->toBaseValue()->dividedBy($force->toBaseValue(), 20, RoundingMode::HALF_UP);

        return Velocity::metersPerSecond($base);
    }

    public function dividedByVelocity(Velocity $velocity): Force
    {
        $base = $this->toBaseValue()->dividedBy($velocity->toBaseValue(), 20, RoundingMode::HALF_UP);

        return Force::newtons($base);
    }
}
