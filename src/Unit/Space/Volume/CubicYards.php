<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * Cubic yard (yd^3) -- an imperial/US customary unit of volume equal to 0.764554857984 cubic meters.
 *
 * Derived from the yard (0.9144 m)^3. Used in the US for concrete, gravel, mulch,
 * and bulk material measurement. One cubic yard equals exactly 27 cubic feet.
 *
 * @see Volume::cubicYards() to create a Volume quantity in cubic yards.
 */
final readonly class CubicYards extends VolumeUnit
{
    private const float FACTOR = 0.764554857984;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'yd3';
    }
}
