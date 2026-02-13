<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Force;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\ForceUnit;
use Override;

/**
 * Meganewton (MN) -- one million newtons.
 *
 * Symbol: MN. Conversion factor: 10^6 (1 MN = 1,000,000 N).
 * Used for very large forces in civil engineering, such as bridge load capacities
 * and rocket engine thrust. A Saturn V first stage produced approximately 34 MN of thrust.
 *
 * @see Force::meganewtons() for the factory method
 */
final readonly class Meganewtons extends ForceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MEGA->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'MN';
    }
}
