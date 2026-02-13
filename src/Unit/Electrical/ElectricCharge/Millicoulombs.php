<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricCharge;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricChargeUnit;
use Override;

/**
 * The millicoulomb (mC) — one thousandth of a coulomb.
 *
 * Used in electrochemistry and small-charge measurements.
 * Factor: 10^-3. 1 mC = 0.001 C.
 *
 * @see ElectricCharge::millicoulombs()
 */
final readonly class Millicoulombs extends ElectricChargeUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'mC';
    }
}
