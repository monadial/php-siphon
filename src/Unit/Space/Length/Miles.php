<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Length;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Override;

/**
 * Mile (mi) -- an imperial/US customary unit of length equal to exactly 1609.344 meters.
 *
 * Defined as exactly 5280 feet or 1760 yards. The primary unit for road distances
 * in the US, UK, and a few other countries.
 *
 * @see Length::miles() to create a Length quantity in miles.
 */
final readonly class Miles extends LengthUnit
{
    private const float FACTOR = 1609.344;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'mi';
    }
}
