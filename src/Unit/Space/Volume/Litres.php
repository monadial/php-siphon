<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * Litre (L) -- a metric unit of volume equal to 10^-3 cubic meters (1 cubic decimeter).
 *
 * Accepted for use with the SI system. The most widely used unit for liquid volumes
 * worldwide. A standard water bottle holds about 0.5 to 1.5 litres.
 *
 * @see Volume::litres() to create a Volume quantity in litres.
 */
final readonly class Litres extends VolumeUnit
{
    private const float FACTOR = 0.001;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'L';
    }
}
