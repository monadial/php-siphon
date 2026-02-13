<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricalResistance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricalResistanceUnit;
use Override;

/**
 * The milliohm (mOhm) — one thousandth of an ohm.
 *
 * Used in current sensing, battery internal resistance, and PCB trace
 * resistance measurements.
 * Factor: 10^-3. 1 mOhm = 0.001 Ohm.
 *
 * @see ElectricalResistance::milliohms()
 */
final readonly class Milliohms extends ElectricalResistanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'mOhm';
    }
}
