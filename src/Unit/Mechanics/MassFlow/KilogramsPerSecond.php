<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\MassFlow;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\MassFlowUnit;
use Override;

/**
 * Kilograms per second (kg/s) -- the SI unit of mass flow rate.
 *
 * Symbol: kg/s. Conversion factor: 1 (base unit).
 * Used in fluid dynamics and process engineering. A typical garden hose delivers
 * approximately 0.2 kg/s of water.
 *
 * @see MassFlow::kilogramsPerSecond() for the factory method
 */
final readonly class KilogramsPerSecond extends MassFlowUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'kg/s';
    }
}
