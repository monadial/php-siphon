<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Area;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\AreaUnit;
use Override;

/**
 * Square yard (yd^2) -- an imperial/US customary unit of area equal to 0.83612736 square meters.
 *
 * Derived from the yard (0.9144 m)^2. Used in the textile industry for fabric
 * measurement and in some countries for land area. Equals exactly 9 square feet.
 *
 * @see Area::squareYards() to create an Area quantity in square yards.
 */
final readonly class SquareYards extends AreaUnit
{
    private const float FACTOR = 0.83612736;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'yd2';
    }
}
