<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * US liquid pint (pt) -- a US customary unit of volume equal to approximately 4.732 * 10^-4 cubic meters.
 *
 * Equal to 2 US cups, 16 US fluid ounces, or approximately 473.176 mL.
 * Used in the US for milk, ice cream, and draft beer serving sizes.
 *
 * @see Volume::usPints() to create a Volume quantity in US pints.
 */
final readonly class UsPints extends VolumeUnit
{
    private const float FACTOR = 4.73176473e-4;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'pt';
    }
}
