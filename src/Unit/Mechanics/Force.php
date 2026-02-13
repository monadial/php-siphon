<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Mass\Mass;
use Monadial\Siphon\Unit\Mechanics\Force\Dynes;
use Monadial\Siphon\Unit\Mechanics\Force\KilogramForce;
use Monadial\Siphon\Unit\Mechanics\Force\Kilonewtons;
use Monadial\Siphon\Unit\Mechanics\Force\Meganewtons;
use Monadial\Siphon\Unit\Mechanics\Force\Millinewtons;
use Monadial\Siphon\Unit\Mechanics\Force\Newtons;
use Monadial\Siphon\Unit\Mechanics\Force\PoundForce;
use Monadial\Siphon\Unit\Motion\Acceleration;
use Monadial\Siphon\Unit\Motion\Velocity;
use Monadial\Siphon\Unit\Space\Area;
use Monadial\Siphon\Unit\Space\Length;

/**
 * Force measures an interaction that changes the motion of an object.
 *
 * The SI unit of force is the newton (N). Force is a derived quantity with dimension
 * M*L*T^-2, equivalent to kg*m/s^2. Newton's second law defines force as the product
 * of mass and acceleration (F = m*a).
 *
 * Available units: Millinewtons (10^-3), Newtons (base, factor 1), Kilonewtons (10^3),
 * Meganewtons (10^6), Dynes (10^-5), KilogramForce (9.80665), PoundForce (4.448222).
 *
 * Cross-dimensional operations:
 * - Force * Length = Energy (W = F*d)
 * - Force * Velocity = Power (P = F*v)
 * - Force / Area = Pressure (P = F/A)
 * - Force / Mass = Acceleration (a = F/m)
 * - Force / Acceleration = Mass (m = F/a)
 *
 * Example usage:
 * ```
 * $force = Force::newtons(100);
 * $kn = $force->toKilonewtons();
 * $accel = $force->dividedByMass(Mass::kilograms(10));
 * ```
 *
 * @see ForceUnit for the abstract unit base class
 * @template-extends Quantity<ForceUnit>
 */
final readonly class Force extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function dynes(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Dynes::make());
    }

    public static function dyne(BigDecimal|int|float|string $value): self
    {
        return self::dynes($value);
    }

    public static function kilogramForce(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), KilogramForce::make());
    }

    public static function kilonewtons(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Kilonewtons::make());
    }

    public static function kilonewton(BigDecimal|int|float|string $value): self
    {
        return self::kilonewtons($value);
    }

    public static function meganewtons(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Meganewtons::make());
    }

    public static function meganewton(BigDecimal|int|float|string $value): self
    {
        return self::meganewtons($value);
    }

    public static function millinewtons(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Millinewtons::make());
    }

    public static function millinewton(BigDecimal|int|float|string $value): self
    {
        return self::millinewtons($value);
    }

    public static function newtons(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Newtons::make());
    }

    public static function newton(BigDecimal|int|float|string $value): self
    {
        return self::newtons($value);
    }

    public static function poundForce(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), PoundForce::make());
    }

    // END_TYPED_FACTORIES
    public function toNewtons(): self
    {
        return $this->scaleTo(Newtons::make());
    }

    public function toKilonewtons(): self
    {
        return $this->scaleTo(Kilonewtons::make());
    }

    public function toMeganewtons(): self
    {
        return $this->scaleTo(Meganewtons::make());
    }

    public function toMillinewtons(): self
    {
        return $this->scaleTo(Millinewtons::make());
    }

    public function toDynes(): self
    {
        return $this->scaleTo(Dynes::make());
    }

    public function toPoundForce(): self
    {
        return $this->scaleTo(PoundForce::make());
    }

    public function toKilogramForce(): self
    {
        return $this->scaleTo(KilogramForce::make());
    }

    public function timesLength(Length $length): Energy
    {
        $base = $this->toBaseValue()->multipliedBy($length->toBaseValue());

        return Energy::joules($base);
    }

    public function timesVelocity(Velocity $velocity): Power
    {
        $base = $this->toBaseValue()->multipliedBy($velocity->toBaseValue());

        return Power::watts($base);
    }

    public function dividedByArea(Area $area): Pressure
    {
        $base = $this->toBaseValue()->dividedBy($area->toBaseValue(), 20, RoundingMode::HALF_UP);

        return Pressure::pascals($base);
    }

    public function dividedByMass(Mass $mass): Acceleration
    {
        $base = $this->toBaseValue()->dividedBy($mass->toBaseValue(), 20, RoundingMode::HALF_UP);

        return Acceleration::metersPerSecondSquared($base);
    }

    public function dividedByAcceleration(Acceleration $acceleration): Mass
    {
        $base = $this->toBaseValue()->dividedBy($acceleration->toBaseValue(), 20, RoundingMode::HALF_UP);

        return Mass::kilograms($base);
    }
}
