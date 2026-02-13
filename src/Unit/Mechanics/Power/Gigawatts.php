<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Power;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\PowerUnit;
use Override;

/**
 * Gigawatt (GW) -- one billion watts.
 *
 * Symbol: GW. Conversion factor: 10^9 (1 GW = 1,000,000,000 W).
 * Used for national power grid capacity and large-scale energy infrastructure.
 * A large nuclear power station typically generates 1-1.6 GW.
 *
 * @see Power::gigawatts() for the factory method
 */
final readonly class Gigawatts extends PowerUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::GIGA->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'GW';
    }
}
