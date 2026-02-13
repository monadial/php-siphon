<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\MagneticFluxDensity;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\MagneticFluxDensityUnit;
use Override;

/**
 * The millitesla (mT) — one thousandth of a tesla.
 *
 * Used in permanent magnet characterization and industrial magnetic
 * field measurements.
 * Factor: 10^-3. 1 mT = 0.001 T.
 *
 * @see MagneticFluxDensity::milliteslas()
 */
final readonly class Milliteslas extends MagneticFluxDensityUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'mT';
    }
}
