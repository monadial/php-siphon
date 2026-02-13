<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Area;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\AreaUnit;
use Override;

/**
 * Acre (ac) -- an imperial/US customary unit of area equal to 4046.8564224 square meters.
 *
 * Historically defined as the area that one yoke of oxen could plough in a day.
 * One acre equals 1/640 of a square mile or 43,560 square feet. Widely used
 * for land measurement in the US, UK, and former British colonies.
 *
 * @see Area::acres() to create an Area quantity in acres.
 */
final readonly class Acres extends AreaUnit
{
    private const float FACTOR = 4046.8564224;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'ac';
    }
}
