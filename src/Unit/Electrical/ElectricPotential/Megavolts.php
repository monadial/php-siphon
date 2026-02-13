<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricPotential;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricPotentialUnit;
use Override;

/**
 * The megavolt (MV) — one million volts.
 *
 * Used in particle accelerators, lightning research, and ultra-high-voltage
 * transmission systems.
 * Factor: 10^6. 1 MV = 1000000 V.
 *
 * @see ElectricPotential::megavolts()
 */
final readonly class Megavolts extends ElectricPotentialUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MEGA->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'MV';
    }
}
