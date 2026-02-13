<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricPotential;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricPotentialUnit;
use Override;

/**
 * The millivolt (mV) — one thousandth of a volt.
 *
 * Used in thermocouple readings, biomedical signals (EEG, ECG), and
 * low-level sensor outputs.
 * Factor: 10^-3. 1 mV = 0.001 V.
 *
 * @see ElectricPotential::millivolts()
 */
final readonly class Millivolts extends ElectricPotentialUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'mV';
    }
}
