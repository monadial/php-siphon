<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Length;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Override;

/**
 * Nautical mile (nmi) -- a unit of length equal to exactly 1852 meters.
 *
 * Originally defined as one minute of arc of latitude along any meridian.
 * The standard unit for maritime and air navigation worldwide. One knot
 * equals one nautical mile per hour.
 *
 * @see Length::nauticalMiles() to create a Length quantity in nautical miles.
 */
final readonly class NauticalMiles extends LengthUnit
{
    private const int FACTOR = 1852;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'nmi';
    }
}
