<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * Hectolitre (hL) -- a metric unit of volume equal to 10^-1 cubic meters (100 litres).
 *
 * Primarily used in the beverage industry for wine, beer, and juice production.
 * A standard wine barrel holds approximately 2.25 hL.
 *
 * @see Volume::hectolitres() to create a Volume quantity in hectolitres.
 */
final readonly class Hectolitres extends VolumeUnit
{
    private const float FACTOR = 0.1;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'hL';
    }
}
