<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * Millilitre (mL) -- a metric unit of volume equal to 10^-6 cubic meters (one cubic centimeter).
 *
 * The most common unit for small liquid volumes in medicine, cooking, and chemistry.
 * A standard medical syringe holds between 1 and 10 mL.
 *
 * @see Volume::millilitres() to create a Volume quantity in millilitres.
 */
final readonly class Millilitres extends VolumeUnit
{
    private const float FACTOR = 1e-6;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'mL';
    }
}
