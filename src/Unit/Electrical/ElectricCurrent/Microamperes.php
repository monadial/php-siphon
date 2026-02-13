<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricCurrent;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricCurrentUnit;
use Override;

/**
 * The microampere (uA) — one millionth of an ampere.
 *
 * Used in low-power electronics, biomedical sensors, and leakage current
 * measurements.
 * Factor: 10^-6. 1 uA = 0.000001 A.
 *
 * @see ElectricCurrent::microamperes()
 */
final readonly class Microamperes extends ElectricCurrentUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MICRO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'uA';
    }
}
