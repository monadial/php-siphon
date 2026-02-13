<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Area;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\AreaUnit;
use Override;

/**
 * Square foot (ft^2) -- an imperial/US customary unit of area equal to 0.09290304 square meters.
 *
 * Derived from the foot (0.3048 m)^2. The primary unit for floor space and
 * real estate measurements in the US. Equals exactly 144 square inches.
 *
 * @see Area::squareFeet() to create an Area quantity in square feet.
 */
final readonly class SquareFeet extends AreaUnit
{
    private const float FACTOR = 0.09290304;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'ft2';
    }
}
