<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Length;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Override;

/**
 * Foot (ft) -- an imperial/US customary unit of length equal to exactly 0.3048 meters.
 *
 * Defined as exactly 12 inches or 304.8 millimeters. Used extensively in aviation
 * (altitude), construction, and real estate in the US and UK.
 *
 * @see Length::feet() to create a Length quantity in feet.
 */
final readonly class Feet extends LengthUnit
{
    private const float FACTOR = 0.3048;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'ft';
    }
}
