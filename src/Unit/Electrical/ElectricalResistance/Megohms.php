<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricalResistance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricalResistanceUnit;
use Override;

/**
 * The megohm (MOhm) — one million ohms.
 *
 * Used in insulation resistance testing, high-impedance circuits, and
 * electrostatic discharge (ESD) protection measurements.
 * Factor: 10^6. 1 MOhm = 1000000 Ohm.
 *
 * @see ElectricalResistance::megohms()
 */
final readonly class Megohms extends ElectricalResistanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MEGA->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'MOhm';
    }
}
