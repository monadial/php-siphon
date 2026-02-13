<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\Capacitance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\CapacitanceUnit;
use Override;

/**
 * The picofarad (pF) — one trillionth of a farad.
 *
 * Typical of small ceramic capacitors used in RF and high-frequency circuits.
 * Factor: 10^-12. 1 pF = 0.000000000001 F.
 *
 * @see Capacitance::picofarads()
 */
final readonly class Picofarads extends CapacitanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::PICO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'pF';
    }
}
