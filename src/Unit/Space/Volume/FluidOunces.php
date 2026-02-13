<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * US fluid ounce (fl oz) -- a US customary unit of volume equal to approximately 2.957 * 10^-5 cubic meters.
 *
 * Equal to 1/128 of a US gallon or approximately 29.574 mL. Used in the US for
 * beverage labelling, nutrition facts, and liquid product measurement.
 *
 * @see Volume::fluidOunces() to create a Volume quantity in fluid ounces.
 */
final readonly class FluidOunces extends VolumeUnit
{
    private const float FACTOR = 2.95735295625e-5;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'fl oz';
    }
}
