<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Force;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\ForceUnit;
use Override;

/**
 * Newton (N) -- the SI unit of force.
 *
 * Symbol: N. Conversion factor: 1 (base unit).
 * One newton is the force required to accelerate a one-kilogram mass at one meter
 * per second squared (1 N = 1 kg*m/s^2). Named after Sir Isaac Newton.
 *
 * @see Force::newtons() for the factory method
 */
final readonly class Newtons extends ForceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'N';
    }
}
