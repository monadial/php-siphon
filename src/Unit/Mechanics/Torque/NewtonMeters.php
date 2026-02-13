<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Torque;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\TorqueUnit;
use Override;

/**
 * Newton meter (N*m) -- the SI unit of torque.
 *
 * Symbol: N*m. Conversion factor: 1 (base unit).
 * One newton meter is the torque produced by a force of one newton applied at a
 * perpendicular distance of one meter from the axis of rotation.
 *
 * @see Torque::newtonMeters() for the factory method
 */
final readonly class NewtonMeters extends TorqueUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'N*m';
    }
}
