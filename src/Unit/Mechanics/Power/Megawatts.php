<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Power;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\PowerUnit;
use Override;

/**
 * Megawatt (MW) -- one million watts.
 *
 * Symbol: MW. Conversion factor: 10^6 (1 MW = 1,000,000 W).
 * Used for power plant capacity and large industrial equipment.
 * A single modern wind turbine typically has a capacity of 2-5 MW.
 *
 * @see Power::megawatts() for the factory method
 */
final readonly class Megawatts extends PowerUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MEGA->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'MW';
    }
}
