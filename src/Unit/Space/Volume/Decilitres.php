<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * Decilitre (dL) -- a metric unit of volume equal to 10^-4 cubic meters (100 millilitres).
 *
 * Used in Scandinavian and some European recipes and food labelling.
 * Blood chemistry results are often reported per decilitre (e.g. mg/dL).
 *
 * @see Volume::decilitres() to create a Volume quantity in decilitres.
 */
final readonly class Decilitres extends VolumeUnit
{
    private const float FACTOR = 1e-4;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'dL';
    }
}
