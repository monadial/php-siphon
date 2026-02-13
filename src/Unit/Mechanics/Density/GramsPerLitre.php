<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Density;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\DensityUnit;
use Override;

/**
 * Grams per litre (g/L) -- a commonly used density unit equivalent to kg/m^3.
 *
 * Symbol: g/L. Conversion factor: 1 (numerically equal to kg/m^3 since
 * 1 g/L = 0.001 kg / 0.001 m^3 = 1 kg/m^3).
 * Convenient for expressing concentrations in chemistry and beverage industries.
 *
 * @see Density::gramsPerLitre() for the factory method
 */
final readonly class GramsPerLitre extends DensityUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'g/L';
    }
}
