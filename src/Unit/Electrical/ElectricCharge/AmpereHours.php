<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricCharge;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Electrical\ElectricChargeUnit;
use Override;

/**
 * The ampere-hour (Ah) — a practical unit of electric charge.
 *
 * Widely used for battery capacity ratings. One ampere-hour equals the
 * charge transported by a steady current of one ampere flowing for one hour.
 * Factor: 3600. 1 Ah = 3600 C.
 *
 * @see ElectricCharge::ampereHours()
 */
final readonly class AmpereHours extends ElectricChargeUnit
{
    private const int FACTOR = 3600;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'Ah';
    }
}
