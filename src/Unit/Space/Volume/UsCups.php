<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * US cup (cup) -- a US customary unit of volume equal to approximately 2.366 * 10^-4 cubic meters.
 *
 * Equal to 8 US fluid ounces, 1/2 US pint, or approximately 236.588 mL.
 * The standard volume measure in American cooking recipes.
 *
 * @see Volume::usCups() to create a Volume quantity in US cups.
 */
final readonly class UsCups extends VolumeUnit
{
    private const float FACTOR = 2.365882365e-4;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'cup';
    }
}
