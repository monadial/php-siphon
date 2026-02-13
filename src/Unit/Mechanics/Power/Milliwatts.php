<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Power;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\PowerUnit;
use Override;

/**
 * Milliwatt (mW) -- one thousandth of a watt.
 *
 * Symbol: mW. Conversion factor: 10^-3 (1 mW = 0.001 W).
 * Used in electronics, telecommunications, and signal processing.
 * A typical laser pointer emits 1-5 mW of optical power.
 *
 * @see Power::milliwatts() for the factory method
 */
final readonly class Milliwatts extends PowerUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'mW';
    }
}
