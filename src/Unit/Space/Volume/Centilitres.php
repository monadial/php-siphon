<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * Centilitre (cL) -- a metric unit of volume equal to 10^-5 cubic meters (10 millilitres).
 *
 * Commonly used in Europe for beverage servings and drink volumes.
 * A standard wine glass pour is approximately 15 cL.
 *
 * @see Volume::centilitres() to create a Volume quantity in centilitres.
 */
final readonly class Centilitres extends VolumeUnit
{
    private const float FACTOR = 1e-5;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'cL';
    }
}
