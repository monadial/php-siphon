<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\VolumeFlow;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\VolumeFlowUnit;
use Override;

/**
 * Litres per second (L/s) -- a metric volume flow rate unit.
 *
 * Symbol: L/s. Conversion factor: 10^-3 (1 L/s = 0.001 m^3/s).
 * Commonly used in water supply engineering and fire protection system design.
 * A typical household faucet delivers 0.1-0.2 L/s.
 *
 * @see VolumeFlow::litresPerSecond() for the factory method
 */
final readonly class LitresPerSecond extends VolumeFlowUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'L/s';
    }
}
