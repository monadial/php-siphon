<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricPotential;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricPotentialUnit;
use Override;

/**
 * The kilovolt (kV) — one thousand volts.
 *
 * Used in power distribution, X-ray tube voltages, and high-voltage testing.
 * Factor: 10^3. 1 kV = 1000 V.
 *
 * @see ElectricPotential::kilovolts()
 */
final readonly class Kilovolts extends ElectricPotentialUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'kV';
    }
}
