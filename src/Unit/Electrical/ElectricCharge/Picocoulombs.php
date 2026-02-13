<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricCharge;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricChargeUnit;
use Override;

/**
 * The picocoulomb (pC) — one trillionth of a coulomb.
 *
 * Used in radiation detection and charge-sensitive amplifier measurements.
 * Factor: 10^-12. 1 pC = 0.000000000001 C.
 *
 * @see ElectricCharge::picocoulombs()
 */
final readonly class Picocoulombs extends ElectricChargeUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::PICO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'pC';
    }
}
