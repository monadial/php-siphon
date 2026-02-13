<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\MagneticFlux;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\MagneticFluxUnit;
use Override;

/**
 * The milliweber (mWb) — one thousandth of a weber.
 *
 * Used in transformer design and small electromagnetic device measurements.
 * Factor: 10^-3. 1 mWb = 0.001 Wb.
 *
 * @see MagneticFlux::milliwebers()
 */
final readonly class Milliwebers extends MagneticFluxUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'mWb';
    }
}
