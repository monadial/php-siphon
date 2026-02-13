<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\VolumeFlow;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\VolumeFlowUnit;
use Override;

/**
 * Cubic meters per second (m^3/s) -- the SI unit of volume flow rate.
 *
 * Symbol: m3/s. Conversion factor: 1 (base unit).
 * Used in hydrology and large-scale fluid dynamics. The Amazon River has an
 * average discharge of approximately 209,000 m^3/s.
 *
 * @see VolumeFlow::cubicMetersPerSecond() for the factory method
 */
final readonly class CubicMetersPerSecond extends VolumeFlowUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'm3/s';
    }
}
