<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Motion;

use Brick\Math\BigDecimal;

use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Time\Time;
use Monadial\Siphon\Unit\Motion\Acceleration\FeetPerSecondSquared;
use Monadial\Siphon\Unit\Motion\Acceleration\MetersPerSecondSquared;
use Monadial\Siphon\Unit\Motion\Acceleration\StandardGravity;

/**
 * @psalm-api
 * @psalm-immutable
 * @template-extends Quantity<AccelerationUnit>
 */
final readonly class Acceleration extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function feetPerSecondSquared(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), FeetPerSecondSquared::make());
    }

    public static function metersPerSecondSquared(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), MetersPerSecondSquared::make());
    }

    public static function standardGravity(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), StandardGravity::make());
    }

    // END_TYPED_FACTORIES
    public function toMetersPerSecondSquared(): self
    {
        return $this->scaleTo(MetersPerSecondSquared::make());
    }

    public function toFeetPerSecondSquared(): self
    {
        return $this->scaleTo(FeetPerSecondSquared::make());
    }

    public function toStandardGravity(): self
    {
        return $this->scaleTo(StandardGravity::make());
    }

    // ---------------------------------------------------------------
    // Cross-dimensional operations
    // ---------------------------------------------------------------

    /**
     * @psalm-suppress ImpureMethodCall
     */
    public function timesTime(Time $time): Velocity
    {
        $base = $this->toBaseValue()->multipliedBy($time->toBaseValue());
        return Velocity::metersPerSecond($base);
    }
}
