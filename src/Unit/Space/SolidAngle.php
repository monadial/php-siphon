<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Quantity;
use Monadial\Siphon\Unit\Space\SolidAngle\SquareDegrees;
use Monadial\Siphon\Unit\Space\SolidAngle\Steradians;

/**
 * SolidAngle represents the two-dimensional angle subtended at a point in three-dimensional space.
 *
 * The SI unit of solid angle is the steradian (sr), defined as the solid angle that,
 * having its vertex at the centre of a sphere, cuts off an area on the surface equal
 * to the square of the radius. A full sphere subtends 4*pi steradians.
 *
 * Available units: Steradians (sr), SquareDegrees (deg^2).
 *
 * Usage:
 *     $solidAngle = SolidAngle::steradians(1);
 *     $inSquareDeg = $solidAngle->toSquareDegrees(); // ~3282.8 deg^2
 *
 * @see SolidAngleUnit for the abstract unit base class.
 * @template-extends Quantity<SolidAngleUnit>
 */
final readonly class SolidAngle extends Quantity
{
    // BEGIN_TYPED_FACTORIES
    public static function squareDegrees(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), SquareDegrees::make());
    }

    public static function squareDegree(BigDecimal|int|float|string $value): self
    {
        return self::squareDegrees($value);
    }

    public static function steradians(BigDecimal|int|float|string $value): self
    {
        return new self(BigDecimal::of($value), Steradians::make());
    }

    public static function steradian(BigDecimal|int|float|string $value): self
    {
        return self::steradians($value);
    }

    // END_TYPED_FACTORIES
    public function toSteradians(): self
    {
        return $this->scaleTo(Steradians::make());
    }

    public function toSquareDegrees(): self
    {
        return $this->scaleTo(SquareDegrees::make());
    }
}
