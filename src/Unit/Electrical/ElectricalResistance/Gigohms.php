<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricalResistance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricalResistanceUnit;
use Override;

/**
 * The gigohm (GOhm) — one billion ohms.
 *
 * Used in ultra-high resistance measurements such as cable insulation
 * testing and electrometer input impedance specifications.
 * Factor: 10^9. 1 GOhm = 1000000000 Ohm.
 *
 * @see ElectricalResistance::gigohms()
 */
final readonly class Gigohms extends ElectricalResistanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::GIGA->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'GOhm';
    }
}
