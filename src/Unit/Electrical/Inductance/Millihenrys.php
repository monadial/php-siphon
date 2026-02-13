<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\Inductance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\InductanceUnit;
use Override;

/**
 * The millihenry (mH) — one thousandth of a henry.
 *
 * Common in power supply filter inductors and relay coils.
 * Factor: 10^-3. 1 mH = 0.001 H.
 *
 * @see Inductance::millihenrys()
 */
final readonly class Millihenrys extends InductanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'mH';
    }
}
