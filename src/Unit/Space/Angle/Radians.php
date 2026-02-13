<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Angle;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\AngleUnit;
use Override;

/**
 * Radian (rad) -- the SI unit of plane angle.
 *
 * Defined as the angle subtended at the centre of a circle by an arc whose length
 * equals the radius. This is the reference unit (factor = 1) for all angle conversions.
 * A full circle is 2*pi radians.
 *
 * @see Angle::radians() to create an Angle quantity in radians.
 */
final readonly class Radians extends AngleUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::one();
    }

    #[Override]
    public function symbol(): string
    {
        return 'rad';
    }
}
