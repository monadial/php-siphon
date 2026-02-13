<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * Cubic inch (in^3) -- an imperial/US customary unit of volume equal to 1.6387064 * 10^-5 cubic meters.
 *
 * Derived from the inch (0.0254 m)^3. Used in the US for engine displacement
 * measurements and material specifications. 1 in^3 is approximately 16.387 mL.
 *
 * @see Volume::cubicInches() to create a Volume quantity in cubic inches.
 */
final readonly class CubicInches extends VolumeUnit
{
    private const float FACTOR = 1.6387064e-5;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'in3';
    }
}
