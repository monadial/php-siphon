<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Area;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\AreaUnit;
use Override;

/**
 * Square kilometer (km^2) -- a unit of area equal to 10^6 square meters.
 *
 * Used for geographic areas such as cities, countries, and bodies of water.
 * The city of Paris covers approximately 105 km^2.
 *
 * @see Area::squareKilometers() to create an Area quantity in square kilometers.
 */
final readonly class SquareKilometers extends AreaUnit
{
    private const int FACTOR = 1_000_000;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'km2';
    }
}
