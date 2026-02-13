<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\MagneticFlux;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\MagneticFluxUnit;
use Override;

/**
 * The microweber (uWb) — one millionth of a weber.
 *
 * Used in sensitive magnetic flux measurements and small-scale magnetic
 * circuit analysis.
 * Factor: 10^-6. 1 uWb = 0.000001 Wb.
 *
 * @see MagneticFlux::microwebers()
 */
final readonly class Microwebers extends MagneticFluxUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MICRO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'uWb';
    }
}
