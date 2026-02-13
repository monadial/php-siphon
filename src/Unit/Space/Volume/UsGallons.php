<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * US gallon (gal) -- a US customary unit of volume equal to approximately 3.785 * 10^-3 cubic meters.
 *
 * Equal to 4 US quarts, 8 US pints, or approximately 3.785 litres. The standard unit
 * for fuel pricing and large liquid volumes in the US. Smaller than the imperial gallon.
 *
 * @see Volume::usGallons() to create a Volume quantity in US gallons.
 */
final readonly class UsGallons extends VolumeUnit
{
    private const float FACTOR = 0.003785411784;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'gal';
    }
}
