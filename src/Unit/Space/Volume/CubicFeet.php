<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * Cubic foot (ft^3) -- an imperial/US customary unit of volume equal to 0.028316846592 cubic meters.
 *
 * Derived from the foot (0.3048 m)^3. Used in the US for shipping container capacity,
 * refrigerator/freezer volume, and natural gas measurement. Equals exactly 1728 cubic inches.
 *
 * @see Volume::cubicFeet() to create a Volume quantity in cubic feet.
 */
final readonly class CubicFeet extends VolumeUnit
{
    private const float FACTOR = 0.028316846592;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'ft3';
    }
}
