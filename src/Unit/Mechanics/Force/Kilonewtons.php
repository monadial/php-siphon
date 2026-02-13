<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Force;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\ForceUnit;
use Override;

/**
 * Kilonewton (kN) -- one thousand newtons.
 *
 * Symbol: kN. Conversion factor: 10^3 (1 kN = 1000 N).
 * Commonly used in structural engineering for load calculations. A typical
 * passenger car weighs approximately 15 kN.
 *
 * @see Force::kilonewtons() for the factory method
 */
final readonly class Kilonewtons extends ForceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'kN';
    }
}
