<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\MagneticFluxDensity;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\MagneticFluxDensityUnit;
use Override;

/**
 * The microtesla (uT) — one millionth of a tesla.
 *
 * Used for measuring the Earth's magnetic field (25-65 uT) and in
 * geophysical surveys.
 * Factor: 10^-6. 1 uT = 0.000001 T.
 *
 * @see MagneticFluxDensity::microteslas()
 */
final readonly class Microteslas extends MagneticFluxDensityUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MICRO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'uT';
    }
}
