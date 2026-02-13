<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Angle;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\AngleUnit;
use Override;

/**
 * Turn (turn) -- a unit of plane angle equal to 2*pi radians (one full rotation).
 *
 * Also known as a revolution or full circle. One turn equals 360 degrees or 400 gradians.
 * Useful in contexts involving rotational motion, such as RPM (revolutions per minute).
 *
 * @see Angle::turns() to create an Angle quantity in turns.
 */
final readonly class Turns extends AngleUnit
{
    private const string FACTOR = '6.28318530717958647693';

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'turn';
    }
}
