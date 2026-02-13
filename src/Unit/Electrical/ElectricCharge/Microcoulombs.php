<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricCharge;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricChargeUnit;
use Override;

/**
 * The microcoulomb (uC) — one millionth of a coulomb.
 *
 * Used in electrostatics and piezoelectric sensor measurements.
 * Factor: 10^-6. 1 uC = 0.000001 C.
 *
 * @see ElectricCharge::microcoulombs()
 */
final readonly class Microcoulombs extends ElectricChargeUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MICRO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'uC';
    }
}
