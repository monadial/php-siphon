<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * US liquid quart (qt) -- a US customary unit of volume equal to approximately 9.464 * 10^-4 cubic meters.
 *
 * Equal to 2 US pints, 4 US cups, or approximately 946.353 mL.
 * Used in the US for motor oil, paint, and other liquid products.
 *
 * @see Volume::usQuarts() to create a Volume quantity in US quarts.
 */
final readonly class UsQuarts extends VolumeUnit
{
    private const float FACTOR = 9.46352946e-4;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'qt';
    }
}
