<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Length;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Override;

/**
 * Yard (yd) -- an imperial/US customary unit of length equal to exactly 0.9144 meters.
 *
 * Defined as exactly 3 feet or 36 inches. Commonly used in American football
 * field measurements and fabric/textile trade.
 *
 * @see Length::yards() to create a Length quantity in yards.
 */
final readonly class Yards extends LengthUnit
{
    private const float FACTOR = 0.9144;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'yd';
    }
}
