<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricalResistance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricalResistanceUnit;
use Override;

/**
 * The kilohm (kOhm) — one thousand ohms.
 *
 * Common resistor values in electronics, used for pull-up/pull-down resistors,
 * voltage dividers, and signal conditioning.
 * Factor: 10^3. 1 kOhm = 1000 Ohm.
 *
 * @see ElectricalResistance::kilohms()
 */
final readonly class Kilohms extends ElectricalResistanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'kOhm';
    }
}
