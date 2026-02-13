<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\SolidAngle;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\SolidAngleUnit;
use Override;

/**
 * Square degree (deg^2) -- a unit of solid angle equal to (pi/180)^2 steradians.
 *
 * The solid-angle analogue of the square of one degree of arc. Used in astronomy
 * to describe the angular area of sky covered by celestial objects or survey fields.
 * A full sphere covers approximately 41,253 square degrees.
 *
 * @see SolidAngle::squareDegrees() to create a SolidAngle quantity in square degrees.
 */
final readonly class SquareDegrees extends SolidAngleUnit
{
    private const string FACTOR = '0.00030461741978670860';

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'deg2';
    }
}
