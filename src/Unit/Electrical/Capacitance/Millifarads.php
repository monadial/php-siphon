<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\Capacitance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\CapacitanceUnit;
use Override;

/**
 * The millifarad (mF) — one thousandth of a farad.
 *
 * Used for large electrolytic capacitors and supercapacitor modules.
 * Factor: 10^-3. 1 mF = 0.001 F.
 *
 * @see Capacitance::millifarads()
 */
final readonly class Millifarads extends CapacitanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'mF';
    }
}
