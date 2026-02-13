<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\SolidAngle;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\SolidAngleUnit;
use Override;

/**
 * Steradian (sr) -- the SI unit of solid angle.
 *
 * Defined as the solid angle subtended at the centre of a sphere by a portion of
 * the surface whose area equals the square of the radius. This is the reference unit
 * (factor = 1) for all solid angle conversions. A full sphere subtends 4*pi steradians.
 *
 * @see SolidAngle::steradians() to create a SolidAngle quantity in steradians.
 */
final readonly class Steradians extends SolidAngleUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::one();
    }

    #[Override]
    public function symbol(): string
    {
        return 'sr';
    }
}
