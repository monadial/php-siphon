<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Angle;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\AngleUnit;
use Override;

/**
 * Arcminute (arcmin) -- a unit of plane angle equal to 1/60 of a degree, or pi/10800 radians.
 *
 * Used in astronomy, navigation, and cartography for precise angular measurements.
 * Also called "minute of arc." The angular diameter of the full Moon as seen
 * from Earth is about 31 arcminutes.
 *
 * @see Angle::arcminutes() to create an Angle quantity in arcminutes.
 */
final readonly class Arcminutes extends AngleUnit
{
    private const string FACTOR = '0.00029088820866572160';

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'arcmin';
    }
}
