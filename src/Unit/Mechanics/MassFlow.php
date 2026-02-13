<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Mass\Mass;
use Monadial\Siphon\Unit\Mechanics\MassFlow\KilogramsPerHour;
use Monadial\Siphon\Unit\Mechanics\MassFlow\KilogramsPerSecond;
use Monadial\Siphon\Unit\Mechanics\MassFlow\PoundsPerSecond;
use Monadial\Siphon\Unit\Time\Time;

/**
 * Mass flow rate measures the mass of substance passing through a given surface per unit time.
 *
 * The SI unit of mass flow rate is the kilogram per second (kg/s). Mass flow rate is a
 * derived quantity with dimension M*T^-1. It is essential in fluid dynamics, chemical
 * engineering, and thermodynamics for characterizing material transport through pipes,
 * nozzles, and process equipment.
 *
 * Available units: KilogramsPerSecond (base, factor 1), KilogramsPerHour (1/3600),
 * PoundsPerSecond (0.45359237).
 *
 * Cross-dimensional operations:
 * - MassFlow * Time = Mass (m = mdot * t)
 *
 * Example usage:
 * ```
 * $flow = MassFlow::kilogramsPerSecond(5);
 * $mass = $flow->timesTime(Time::minutes(30));
 * $hourly = $flow->toKilogramsPerHour();
 * ```
 *
 * @see MassFlowUnit for the abstract unit base class
 * @template-extends Quantity<MassFlowUnit>
 */
final readonly class MassFlow extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function kilogramsPerHour(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), KilogramsPerHour::make());
    }

    public static function kilogramsPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), KilogramsPerSecond::make());
    }

    public static function poundsPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), PoundsPerSecond::make());
    }

    // END_TYPED_FACTORIES
    public function toKilogramsPerSecond(): self
    {
        return $this->scaleTo(KilogramsPerSecond::make());
    }

    public function toPoundsPerSecond(): self
    {
        return $this->scaleTo(PoundsPerSecond::make());
    }

    public function toKilogramsPerHour(): self
    {
        return $this->scaleTo(KilogramsPerHour::make());
    }

    public function timesTime(Time $time): Mass
    {
        $base = $this->toBaseValue()->multipliedBy($time->toBaseValue());

        return Mass::kilograms($base);
    }
}
