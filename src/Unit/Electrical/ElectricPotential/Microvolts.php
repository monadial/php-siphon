<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricPotential;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricPotentialUnit;
use Override;

/**
 * The microvolt (uV) — one millionth of a volt.
 *
 * Used in sensitive signal processing, EEG brain-wave measurements,
 * and precision voltage references.
 * Factor: 10^-6. 1 uV = 0.000001 V.
 *
 * @see ElectricPotential::microvolts()
 */
final readonly class Microvolts extends ElectricPotentialUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MICRO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'uV';
    }
}
