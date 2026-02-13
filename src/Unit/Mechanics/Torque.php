<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Mechanics\Torque\NewtonMeters;
use Monadial\Siphon\Unit\Mechanics\Torque\PoundFeet;
use Monadial\Siphon\Unit\Space\Length;

/**
 * Torque measures the rotational force applied about an axis.
 *
 * The SI unit of torque is the newton meter (N*m). Torque is a derived quantity with
 * dimension M*L^2*T^-2, sharing the same dimensions as energy but representing a
 * fundamentally different physical concept (rotational vs. translational). Torque is
 * essential in mechanical engineering for engine specifications, fastener tightening,
 * and rotational dynamics.
 *
 * Available units: NewtonMeters (base, factor 1), PoundFeet (1.355818).
 *
 * Cross-dimensional operations:
 * - Torque / Force = Length (lever arm: r = tau/F)
 * - Torque / Length = Force (F = tau/r)
 *
 * Example usage:
 * ```
 * $torque = Torque::newtonMeters(100);
 * $imperial = $torque->toPoundFeet();
 * $force = $torque->dividedByLength(Length::meters('0.5'));
 * ```
 *
 * @see TorqueUnit for the abstract unit base class
 * @template-extends Quantity<TorqueUnit>
 */
final readonly class Torque extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function newtonMeters(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), NewtonMeters::make());
    }

    public static function newtonMeter(BigDecimal|int|float|string $value): self
    {
        return self::newtonMeters($value);
    }

    public static function poundFeet(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), PoundFeet::make());
    }

    // END_TYPED_FACTORIES
    public function toNewtonMeters(): self
    {
        return $this->scaleTo(NewtonMeters::make());
    }

    public function toPoundFeet(): self
    {
        return $this->scaleTo(PoundFeet::make());
    }

    public function dividedByForce(Force $force): Length
    {
        $base = $this->toBaseValue()->dividedBy($force->toBaseValue(), 20, RoundingMode::HALF_UP);

        return Length::meters($base);
    }

    public function dividedByLength(Length $length): Force
    {
        $base = $this->toBaseValue()->dividedBy($length->toBaseValue(), 20, RoundingMode::HALF_UP);

        return Force::newtons($base);
    }
}
