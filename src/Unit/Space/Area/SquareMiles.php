<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Area;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\AreaUnit;
use Override;

/**
 * Square mile (mi^2) -- an imperial/US customary unit of area equal to 2,589,988.110336 square meters.
 *
 * Derived from the mile (1609.344 m)^2. Used for large land areas in the US and UK.
 * One square mile equals exactly 640 acres. Manhattan is about 22.8 square miles.
 *
 * @see Area::squareMiles() to create an Area quantity in square miles.
 */
final readonly class SquareMiles extends AreaUnit
{
    private const float FACTOR = 2_589_988.110336;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'mi2';
    }
}
