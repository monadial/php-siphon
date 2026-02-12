<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Motion;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Space\Length;
use Monadial\Siphon\Unit\Time\Time;
use Monadial\Siphon\Unit\Motion\Velocity\FeetPerSecond;
use Monadial\Siphon\Unit\Motion\Velocity\KilometersPerHour;
use Monadial\Siphon\Unit\Motion\Velocity\KilometersPerSecond;
use Monadial\Siphon\Unit\Motion\Velocity\Knots;
use Monadial\Siphon\Unit\Motion\Velocity\MetersPerSecond;
use Monadial\Siphon\Unit\Motion\Velocity\MilesPerHour;
use Monadial\Siphon\Unit\Motion\Velocity\MillimetersPerSecond;

/**
 * @psalm-api
 * @psalm-immutable
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

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function timesTime(Time $time): Length
    {
        $base = $this->toBaseValue()->multipliedBy($time->toBaseValue());
        return Length::meters($base);
    }

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function dividedByTime(Time $time): Acceleration
    {
        $base = $this->toBaseValue()->dividedBy($time->toBaseValue(), 20, RoundingMode::HALF_UP);
        return Acceleration::metersPerSecondSquared($base);
    }
}
