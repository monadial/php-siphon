<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * Cubic centimeter (cm^3) -- a unit of volume equal to 10^-6 cubic meters.
 *
 * Numerically equivalent to one millilitre. Commonly abbreviated as "cc" in
 * medical and automotive contexts (engine displacement).
 *
 * @see Volume::cubicCentimeters() to create a Volume quantity in cubic centimeters.
 */
final readonly class CubicCentimeters extends VolumeUnit
{
    private const float FACTOR = 1e-6;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'cm3';
    }
}
