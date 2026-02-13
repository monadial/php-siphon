<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricalResistance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricalResistanceUnit;
use Override;

/**
 * The microhm (uOhm) — one millionth of an ohm.
 *
 * Used in precision resistance standards and contact resistance measurements.
 * Factor: 10^-6. 1 uOhm = 0.000001 Ohm.
 *
 * @see ElectricalResistance::microhms()
 */
final readonly class Microhms extends ElectricalResistanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MICRO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'uOhm';
    }
}
