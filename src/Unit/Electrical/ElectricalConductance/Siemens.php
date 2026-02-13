<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricalConductance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricalConductanceUnit;
use Override;

/**
 * The siemens (S) — SI derived unit of electrical conductance.
 *
 * One siemens is the conductance of a conductor in which one ampere of current
 * flows per volt of applied voltage. It is the reciprocal of the ohm.
 * Factor: 1 (base unit). 1 S = 1/Ohm = 1 A/V.
 *
 * @see ElectricalConductance::siemens()
 */
final readonly class Siemens extends ElectricalConductanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'S';
    }
}
