<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Energy;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Override;

/**
 * Millijoule (mJ) -- one thousandth of a joule.
 *
 * Symbol: mJ. Conversion factor: 10^-3 (1 mJ = 0.001 J).
 * Used in electronics and low-energy applications such as sensor power budgets
 * and MEMS device characterization.
 *
 * @see Energy::millijoules() for the factory method
 */
final readonly class Millijoules extends EnergyUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'mJ';
    }
}
