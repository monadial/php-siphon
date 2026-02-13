<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Density;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\DensityUnit;
use Override;

/**
 * Grams per cubic centimeter (g/cm^3) -- a CGS density unit.
 *
 * Symbol: g/cm3. Conversion factor: 1000 (1 g/cm^3 = 1000 kg/m^3).
 * Widely used in material science and geology. Water has a density of approximately
 * 1 g/cm^3, and common metals range from 2.7 (aluminum) to 19.3 (gold).
 *
 * @see Density::gramsPerCubicCentimeter() for the factory method
 */
final readonly class GramsPerCubicCentimeter extends DensityUnit
{
    private const int FACTOR = 1000;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'g/cm3';
    }
}
