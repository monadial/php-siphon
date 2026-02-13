<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Mechanics\VolumeFlow\CubicMetersPerSecond;
use Monadial\Siphon\Unit\Mechanics\VolumeFlow\GallonsPerMinute;
use Monadial\Siphon\Unit\Mechanics\VolumeFlow\LitresPerMinute;
use Monadial\Siphon\Unit\Mechanics\VolumeFlow\LitresPerSecond;
use Monadial\Siphon\Unit\Space\Volume;
use Monadial\Siphon\Unit\Time\Time;

/**
 * Volume flow rate measures the volume of fluid passing through a surface per unit time.
 *
 * The SI unit of volume flow rate is the cubic meter per second (m^3/s). Volume flow rate
 * is a derived quantity with dimension L^3*T^-1. It is widely used in hydraulic engineering,
 * HVAC systems, and process industries to quantify fluid transport through pipes and channels.
 *
 * Available units: CubicMetersPerSecond (base, factor 1), LitresPerSecond (10^-3),
 * LitresPerMinute (1/60000), GallonsPerMinute (6.30902e-5).
 *
 * Cross-dimensional operations:
 * - VolumeFlow * Time = Volume (V = Q * t)
 *
 * Example usage:
 * ```
 * $flow = VolumeFlow::litresPerMinute(120);
 * $volume = $flow->timesTime(Time::hours(1));
 * $si = $flow->toCubicMetersPerSecond();
 * ```
 *
 * @see VolumeFlowUnit for the abstract unit base class
 * @template-extends Quantity<VolumeFlowUnit>
 */
final readonly class VolumeFlow extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function cubicMetersPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), CubicMetersPerSecond::make());
    }

    public static function gallonsPerMinute(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), GallonsPerMinute::make());
    }

    public static function litresPerMinute(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), LitresPerMinute::make());
    }

    public static function litresPerSecond(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), LitresPerSecond::make());
    }

    // END_TYPED_FACTORIES
    public function toCubicMetersPerSecond(): self
    {
        return $this->scaleTo(CubicMetersPerSecond::make());
    }

    public function toLitresPerMinute(): self
    {
        return $this->scaleTo(LitresPerMinute::make());
    }

    public function toGallonsPerMinute(): self
    {
        return $this->scaleTo(GallonsPerMinute::make());
    }

    public function toLitresPerSecond(): self
    {
        return $this->scaleTo(LitresPerSecond::make());
    }

    public function timesTime(Time $time): Volume
    {
        $base = $this->toBaseValue()->multipliedBy($time->toBaseValue());

        return Volume::cubicMeters($base);
    }
}
