<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricalResistance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricalResistanceUnit;
use Override;

/**
 * The nanohm (nOhm) — one billionth of an ohm.
 *
 * Used in superconductor research and ultra-low resistance measurements.
 * Factor: 10^-9. 1 nOhm = 0.000000001 Ohm.
 *
 * @see ElectricalResistance::nanohms()
 */
final readonly class Nanohms extends ElectricalResistanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::NANO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'nOhm';
    }
}
