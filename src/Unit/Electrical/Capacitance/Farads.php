<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\Capacitance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\CapacitanceUnit;
use Override;

/**
 * The farad (F) — SI base unit of electrical capacitance.
 *
 * One farad stores one coulomb of charge at a potential of one volt.
 * Factor: 1 (base unit). 1 F = 1 C/V = 1 A^2*s^4/(kg*m^2).
 *
 * @see Capacitance::farads()
 */
final readonly class Farads extends CapacitanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'F';
    }
}
