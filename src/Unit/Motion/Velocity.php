<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Motion;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Motion\Velocity\FeetPerSecond;
use Monadial\Siphon\Unit\Motion\Velocity\KilometersPerHour;
use Monadial\Siphon\Unit\Motion\Velocity\KilometersPerSecond;
use Monadial\Siphon\Unit\Motion\Velocity\Knots;
use Monadial\Siphon\Unit\Motion\Velocity\MetersPerSecond;
use Monadial\Siphon\Unit\Motion\Velocity\MilesPerHour;
use Monadial\Siphon\Unit\Motion\Velocity\MillimetersPerSecond;
use Monadial\Siphon\Unit\Space\Length;
use Monadial\Siphon\Unit\Time\Time;

/**
 * Velocity quantity measuring the rate of change of position.
 *
 * Dimension formula: L * T^-1 (length per time). The SI derived unit is
 * meters per second (m/s). Available units: MillimetersPerSecond (10^-3),
 * MetersPerSecond (1), KilometersPerSecond (10^3), KilometersPerHour (1/3.6),
 * MilesPerHour (0.44704), Knots (0.514444), FeetPerSecond (0.3048).
 *
 * Cross-dimensional: Velocity * Time = Length, Velocity / Time = Acceleration.
 *
 * ```php
 * $speed = Velocity::kilometersPerHour(100);
 * $mps = $speed->toMetersPerSecond(); // ~27.78 m/s
 * $distance = $speed->timesTime(Time::hours(2)); // 200 km as Length
 * ```
 *
 * @template-extends Quantity<VelocityUnit>
 */
final readonly class Velocity extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function feetPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), FeetPerSecond::make());
    }

    public static function kilometersPerHour(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), KilometersPerHour::make());
    }

    public static function kilometersPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), KilometersPerSecond::make());
    }

    public static function knots(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Knots::make());
    }

    public static function knot(BigDecimal|int|float|string $value): self
    {
        return self::knots($value);
    }

    public static function metersPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), MetersPerSecond::make());
    }

    public static function milesPerHour(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), MilesPerHour::make());
    }

    public static function millimetersPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), MillimetersPerSecond::make());
    }

    // END_TYPED_FACTORIES
    public function toMetersPerSecond(): self
    {
        return $this->scaleTo(MetersPerSecond::make());
    }

    public function toKilometersPerHour(): self
    {
        return $this->scaleTo(KilometersPerHour::make());
    }

    public function toMilesPerHour(): self
    {
        return $this->scaleTo(MilesPerHour::make());
    }

    public function toKnots(): self
    {
        return $this->scaleTo(Knots::make());
    }

    public function toFeetPerSecond(): self
    {
        return $this->scaleTo(FeetPerSecond::make());
    }

    public function toKilometersPerSecond(): self
    {
        return $this->scaleTo(KilometersPerSecond::make());
    }

    public function toMillimetersPerSecond(): self
    {
        return $this->scaleTo(MillimetersPerSecond::make());
    }

    // ---------------------------------------------------------------
    // Cross-dimensional operations
    // ---------------------------------------------------------------

    public function timesTime(Time $time): Length
    {
        $base = $this->toBaseValue()->multipliedBy($time->toBaseValue());

        return Length::meters($base);
    }

    public function dividedByTime(Time $time): Acceleration
    {
        $base = $this->toBaseValue()->dividedBy($time->toBaseValue(), 20, RoundingMode::HALF_UP);

        return Acceleration::metersPerSecondSquared($base);
    }
}
