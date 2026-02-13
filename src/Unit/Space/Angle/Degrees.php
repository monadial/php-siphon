<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Angle;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\AngleUnit;
use Override;

/**
 * Degree (deg) -- a unit of plane angle equal to pi/180 radians.
 *
 * The most familiar angular measure in everyday use, navigation, and geography.
 * A right angle is 90 degrees, a straight angle is 180 degrees, and a full
 * rotation is 360 degrees.
 *
 * @see Angle::degrees() to create an Angle quantity in degrees.
 */
final readonly class Degrees extends AngleUnit
{
    private const string FACTOR = '0.01745329251994329577';

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'deg';
    }
}
