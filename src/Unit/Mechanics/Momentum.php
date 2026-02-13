<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Mass\Mass;
use Monadial\Siphon\Unit\Mechanics\Momentum\KilogramMetersPerSecond;
use Monadial\Siphon\Unit\Mechanics\Momentum\NewtonSeconds;
use Monadial\Siphon\Unit\Motion\Velocity;
use Monadial\Siphon\Unit\Time\Time;

/**
 * Momentum measures the product of an object's mass and velocity.
 *
 * The SI unit of momentum is the kilogram meter per second (kg*m/s). Momentum is a
 * derived quantity with dimension M*L*T^-1. Conservation of momentum is one of the
 * fundamental laws of physics, governing collisions, rocket propulsion, and all
 * mechanical interactions.
 *
 * Available units: KilogramMetersPerSecond (base, factor 1),
 * NewtonSeconds (factor 1, since N*s = kg*m/s by dimensional equivalence).
 *
 * Cross-dimensional operations:
 * - Momentum / Mass = Velocity (v = p/m)
 * - Momentum / Velocity = Mass (m = p/v)
 * - Momentum / Time = Force (F = dp/dt)
 *
 * Example usage:
 * ```
 * $p = Momentum::kilogramMetersPerSecond(500);
 * $velocity = $p->dividedByMass(Mass::kilograms(50));
 * $force = $p->dividedByTime(Time::seconds(2));
 * ```
 *
 * @see MomentumUnit for the abstract unit base class
 * @template-extends Quantity<MomentumUnit>
 */
final readonly class Momentum extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function kilogramMetersPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), KilogramMetersPerSecond::make());
    }

    public static function newtonSeconds(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), NewtonSeconds::make());
    }

    public static function newtonSecond(BigDecimal|int|float|string $value): self
    {
        return self::newtonSeconds($value);
    }

    // END_TYPED_FACTORIES
    public function toNewtonSeconds(): self
    {
        return $this->scaleTo(NewtonSeconds::make());
    }

    public function toKilogramMetersPerSecond(): self
    {
        return $this->scaleTo(KilogramMetersPerSecond::make());
    }

    public function dividedByMass(Mass $mass): Velocity
    {
        $base = $this->toBaseValue()->dividedBy($mass->toBaseValue(), 20, RoundingMode::HALF_UP);

        return Velocity::metersPerSecond($base);
    }

    public function dividedByVelocity(Velocity $velocity): Mass
    {
        $base = $this->toBaseValue()->dividedBy($velocity->toBaseValue(), 20, RoundingMode::HALF_UP);

        return Mass::kilograms($base);
    }

    public function dividedByTime(Time $time): Force
    {
        $base = $this->toBaseValue()->dividedBy($time->toBaseValue(), 20, RoundingMode::HALF_UP);

        return Force::newtons($base);
    }
}
