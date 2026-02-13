<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * Tablespoon (tbsp) -- a US customary unit of volume equal to approximately 1.479 * 10^-5 cubic meters.
 *
 * A standard culinary measure equal to 3 teaspoons or 1/16 of a US cup.
 * Approximately 14.787 mL. Widely used in cooking recipes throughout North America.
 *
 * @see Volume::tablespoons() to create a Volume quantity in tablespoons.
 */
final readonly class Tablespoons extends VolumeUnit
{
    private const float FACTOR = 1.478676478125e-5;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'tbsp';
    }
}
