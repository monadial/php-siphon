<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * Teaspoon (tsp) -- a US customary unit of volume equal to approximately 4.929 * 10^-6 cubic meters.
 *
 * A standard culinary measure equal to 1/3 of a tablespoon or 1/48 of a US cup.
 * Approximately 4.929 mL. Commonly used in cooking recipes and medicine dosing.
 *
 * @see Volume::teaspoons() to create a Volume quantity in teaspoons.
 */
final readonly class Teaspoons extends VolumeUnit
{
    private const float FACTOR = 4.92892159375e-6;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'tsp';
    }
}
