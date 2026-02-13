<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricCharge;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricChargeUnit;
use Override;

/**
 * The nanocoulomb (nC) — one billionth of a coulomb.
 *
 * Used in semiconductor physics and small electrostatic charge measurements.
 * Factor: 10^-9. 1 nC = 0.000000001 C.
 *
 * @see ElectricCharge::nanocoulombs()
 */
final readonly class Nanocoulombs extends ElectricChargeUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::NANO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'nC';
    }
}
