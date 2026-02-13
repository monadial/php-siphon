<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * Imperial gallon (imp gal) -- a British imperial unit of volume equal to exactly 0.00454609 cubic meters.
 *
 * Defined as the volume of 10 pounds of water at 62 degrees Fahrenheit.
 * Equal to approximately 4.546 litres, making it about 20% larger than the US gallon.
 * Still used in the UK for fuel economy (miles per gallon).
 *
 * @see Volume::imperialGallons() to create a Volume quantity in imperial gallons.
 */
final readonly class ImperialGallons extends VolumeUnit
{
    private const float FACTOR = 0.00454609;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'imp gal';
    }
}
