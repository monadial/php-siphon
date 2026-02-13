<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Energy;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Override;

/**
 * Megajoule (MJ) -- one million joules.
 *
 * Symbol: MJ. Conversion factor: 10^6 (1 MJ = 1,000,000 J).
 * Used in energy engineering and fuel comparisons. For example, one litre of
 * gasoline contains approximately 34 MJ of chemical energy.
 *
 * @see Energy::megajoules() for the factory method
 */
final readonly class Megajoules extends EnergyUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MEGA->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'MJ';
    }
}
