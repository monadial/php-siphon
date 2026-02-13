<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricCurrent;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricCurrentUnit;
use Override;

/**
 * The milliampere (mA) — one thousandth of an ampere.
 *
 * Commonly used for LED drive currents, microcontroller consumption,
 * and general electronics measurements.
 * Factor: 10^-3. 1 mA = 0.001 A.
 *
 * @see ElectricCurrent::milliamperes()
 */
final readonly class Milliamperes extends ElectricCurrentUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'mA';
    }
}
