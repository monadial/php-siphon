<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricalConductance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricalConductanceUnit;
use Override;

/**
 * The millisiemens (mS) — one thousandth of a siemens.
 *
 * Used in water-quality testing and conductivity measurements of solutions.
 * Factor: 10^-3. 1 mS = 0.001 S.
 *
 * @see ElectricalConductance::millisiemens()
 */
final readonly class Millisiemens extends ElectricalConductanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'mS';
    }
}
