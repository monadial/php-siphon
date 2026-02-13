<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Density;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\DensityUnit;
use Override;

/**
 * Kilograms per cubic meter (kg/m^3) -- the SI unit of density.
 *
 * Symbol: kg/m3. Conversion factor: 1 (base unit).
 * Water at 4 degrees C has a density of approximately 1000 kg/m^3.
 *
 * @see Density::kilogramsPerCubicMeter() for the factory method
 */
final readonly class KilogramsPerCubicMeter extends DensityUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'kg/m3';
    }
}
