<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Momentum;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\MomentumUnit;
use Override;

/**
 * Newton second (N*s) -- an equivalent unit of momentum and impulse.
 *
 * Symbol: N*s. Conversion factor: 1 (dimensionally equivalent to kg*m/s).
 * Preferred when expressing impulse (force integrated over time). By Newton's second
 * law, 1 N*s = 1 kg*m/s, making the two momentum units interchangeable.
 *
 * @see Momentum::newtonSeconds() for the factory method
 */
final readonly class NewtonSeconds extends MomentumUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'N*s';
    }
}
