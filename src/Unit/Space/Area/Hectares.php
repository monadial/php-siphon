<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Area;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\AreaUnit;
use Override;

/**
 * Hectare (ha) -- a metric unit of area equal to 10,000 square meters.
 *
 * Equivalent to the area of a square with 100-meter sides. Accepted for use
 * with the SI system. The primary unit for agricultural land measurement
 * worldwide. One hectare equals approximately 2.471 acres.
 *
 * @see Area::hectares() to create an Area quantity in hectares.
 */
final readonly class Hectares extends AreaUnit
{
    private const int FACTOR = 10_000;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'ha';
    }
}
