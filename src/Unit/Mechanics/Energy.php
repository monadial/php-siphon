<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Mechanics\Energy\BritishThermalUnits;
use Monadial\Siphon\Unit\Mechanics\Energy\Calories;
use Monadial\Siphon\Unit\Mechanics\Energy\Electronvolts;
use Monadial\Siphon\Unit\Mechanics\Energy\Gigajoules;
use Monadial\Siphon\Unit\Mechanics\Energy\GigawattHours;
use Monadial\Siphon\Unit\Mechanics\Energy\Joules;
use Monadial\Siphon\Unit\Mechanics\Energy\Kilocalories;
use Monadial\Siphon\Unit\Mechanics\Energy\Kilojoules;
use Monadial\Siphon\Unit\Mechanics\Energy\KilowattHours;
use Monadial\Siphon\Unit\Mechanics\Energy\Megajoules;
use Monadial\Siphon\Unit\Mechanics\Energy\MegawattHours;
use Monadial\Siphon\Unit\Mechanics\Energy\Millijoules;
use Monadial\Siphon\Unit\Mechanics\Energy\WattHours;
use Monadial\Siphon\Unit\Space\Length;
use Monadial\Siphon\Unit\Space\Volume;
use Monadial\Siphon\Unit\Time\Time;

/**
 * Energy measures the capacity to do work or transfer heat.
 *
 * The SI unit of energy is the joule (J). Energy is a derived quantity with dimension
 * M*L^2*T^-2, equivalent to kg*m^2/s^2. Energy appears in every branch of physics and
 * engineering, from mechanical work and heat transfer to electrical power and nuclear reactions.
 *
 * Available units: Millijoules (10^-3), Joules (base, factor 1), Kilojoules (10^3),
 * Megajoules (10^6), Gigajoules (10^9), Calories (4.184), Kilocalories (4184),
 * BritishThermalUnits (1055.06), Electronvolts (1.602176634e-19), WattHours (3600),
 * KilowattHours (3600000), MegawattHours (3.6e9), GigawattHours (3.6e12).
 *
 * Cross-dimensional operations:
 * - Energy / Time = Power (P = E/t)
 * - Energy / Power = Time (t = E/P)
 * - Energy / Length = Force (W = F*d, so F = W/d)
 * - Energy / Force = Length (d = W/F)
 * - Energy / Volume = Pressure (E = P*V, so P = E/V)
 *
 * Example usage:
 * ```
 * $energy = Energy::kilowattHours(100);
 * $joules = $energy->toJoules();
 * $power = $energy->dividedByTime(Time::hours(2));
 * ```
 *
 * @see EnergyUnit for the abstract unit base class
 * @template-extends Quantity<EnergyUnit>
 */
final readonly class Energy extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function britishThermalUnits(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), BritishThermalUnits::make());
    }

    public static function britishThermalUnit(BigDecimal|int|float|string $value): self
    {
        return self::britishThermalUnits($value);
    }

    public static function calories(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Calories::make());
    }

    public static function calorie(BigDecimal|int|float|string $value): self
    {
        return self::calories($value);
    }

    public static function electronvolts(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Electronvolts::make());
    }

    public static function electronvolt(BigDecimal|int|float|string $value): self
    {
        return self::electronvolts($value);
    }

    public static function gigajoules(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Gigajoules::make());
    }

    public static function gigajoule(BigDecimal|int|float|string $value): self
    {
        return self::gigajoules($value);
    }

    public static function gigawattHours(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), GigawattHours::make());
    }

    public static function gigawattHour(BigDecimal|int|float|string $value): self
    {
        return self::gigawattHours($value);
    }

    public static function joules(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Joules::make());
    }

    public static function joule(BigDecimal|int|float|string $value): self
    {
        return self::joules($value);
    }

    public static function kilocalories(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilocalories::make());
    }

    public static function kilocalorie(BigDecimal|int|float|string $value): self
    {
        return self::kilocalories($value);
    }

    public static function kilojoules(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilojoules::make());
    }

    public static function kilojoule(BigDecimal|int|float|string $value): self
    {
        return self::kilojoules($value);
    }

    public static function kilowattHours(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), KilowattHours::make());
    }

    public static function kilowattHour(BigDecimal|int|float|string $value): self
    {
        return self::kilowattHours($value);
    }

    public static function megajoules(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Megajoules::make());
    }

    public static function megajoule(BigDecimal|int|float|string $value): self
    {
        return self::megajoules($value);
    }

    public static function megawattHours(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), MegawattHours::make());
    }

    public static function megawattHour(BigDecimal|int|float|string $value): self
    {
        return self::megawattHours($value);
    }

    public static function millijoules(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Millijoules::make());
    }

    public static function millijoule(BigDecimal|int|float|string $value): self
    {
        return self::millijoules($value);
    }

    public static function wattHours(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), WattHours::make());
    }

    public static function wattHour(BigDecimal|int|float|string $value): self
    {
        return self::wattHours($value);
    }

    // END_TYPED_FACTORIES
    public function toJoules(): self
    {
        return $this->scaleTo(Joules::make());
    }

    public function toMillijoules(): self
    {
        return $this->scaleTo(Millijoules::make());
    }

    public function toKilojoules(): self
    {
        return $this->scaleTo(Kilojoules::make());
    }

    public function toMegajoules(): self
    {
        return $this->scaleTo(Megajoules::make());
    }

    public function toGigajoules(): self
    {
        return $this->scaleTo(Gigajoules::make());
    }

    public function toWattHours(): self
    {
        return $this->scaleTo(WattHours::make());
    }

    public function toKilowattHours(): self
    {
        return $this->scaleTo(KilowattHours::make());
    }

    public function toMegawattHours(): self
    {
        return $this->scaleTo(MegawattHours::make());
    }

    public function toGigawattHours(): self
    {
        return $this->scaleTo(GigawattHours::make());
    }

    public function toCalories(): self
    {
        return $this->scaleTo(Calories::make());
    }

    public function toKilocalories(): self
    {
        return $this->scaleTo(Kilocalories::make());
    }

    public function toBritishThermalUnits(): self
    {
        return $this->scaleTo(BritishThermalUnits::make());
    }

    public function toElectronvolts(): self
    {
        return $this->scaleTo(Electronvolts::make());
    }

    public function dividedByTime(Time $time): Power
    {
        $base = $this->toBaseValue()->dividedBy($time->toBaseValue(), 20, RoundingMode::HALF_UP);

        return Power::watts($base);
    }

    public function dividedByPower(Power $power): Time
    {
        $base = $this->toBaseValue()->dividedBy($power->toBaseValue(), 20, RoundingMode::HALF_UP);

        return Time::seconds($base);
    }

    public function dividedByLength(Length $length): Force
    {
        $base = $this->toBaseValue()->dividedBy($length->toBaseValue(), 20, RoundingMode::HALF_UP);

        return Force::newtons($base);
    }

    public function dividedByForce(Force $force): Length
    {
        $base = $this->toBaseValue()->dividedBy($force->toBaseValue(), 20, RoundingMode::HALF_UP);

        return Length::meters($base);
    }

    public function dividedByVolume(Volume $volume): Pressure
    {
        $base = $this->toBaseValue()->dividedBy($volume->toBaseValue(), 20, RoundingMode::HALF_UP);

        return Pressure::pascals($base);
    }
}
