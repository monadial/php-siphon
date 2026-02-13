<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Angle;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\AngleUnit;
use Override;

/**
 * Arcsecond (arcsec) -- a unit of plane angle equal to 1/3600 of a degree, or pi/648000 radians.
 *
 * Used in astronomy for stellar parallax and precise celestial measurements.
 * One arcsecond of latitude on Earth corresponds to approximately 31 meters.
 * Telescope resolving power is often specified in arcseconds.
 *
 * @see Angle::arcseconds() to create an Angle quantity in arcseconds.
 */
final readonly class Arcseconds extends AngleUnit
{
    private const string FACTOR = '0.00000484813681109536';

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'arcsec';
    }
}
