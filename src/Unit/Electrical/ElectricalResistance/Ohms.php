<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricalResistance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricalResistanceUnit;
use Override;

/**
 * The ohm (Ohm) — SI derived unit of electrical resistance.
 *
 * One ohm is the resistance that produces a potential difference of one volt
 * when a current of one ampere flows through it.
 * Factor: 1 (base unit). 1 Ohm = 1 V/A = 1 kg*m^2/(A^2*s^3).
 *
 * @see ElectricalResistance::ohms()
 */
final readonly class Ohms extends ElectricalResistanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'Ohm';
    }
}
