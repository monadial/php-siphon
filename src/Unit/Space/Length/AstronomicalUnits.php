<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Length;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Override;

/**
 * Astronomical unit (au) -- a unit of length equal to exactly 149,597,870,700 meters.
 *
 * Approximately the mean Earth-Sun distance. Defined by the IAU in 2012 as an exact
 * value in meters. Primarily used to express distances within the Solar System.
 *
 * @see Length::astronomicalUnits() to create a Length quantity in astronomical units.
 */
final readonly class AstronomicalUnits extends LengthUnit
{
    private const int FACTOR = 149_597_870_700;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'au';
    }
}
