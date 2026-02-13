<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricCharge;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Electrical\ElectricChargeUnit;
use Override;

/**
 * The milliampere-hour (mAh) — a practical unit of electric charge.
 *
 * Commonly used for small battery capacity ratings (e.g. smartphone batteries).
 * One milliampere-hour equals one thousandth of an ampere-hour.
 * Factor: 3.6. 1 mAh = 3.6 C.
 *
 * @see ElectricCharge::milliampereHours()
 */
final readonly class MilliampereHours extends ElectricChargeUnit
{
    private const float FACTOR = 3.6;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'mAh';
    }
}
