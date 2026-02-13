<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\Capacitance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\CapacitanceUnit;
use Override;

/**
 * The nanofarad (nF) — one billionth of a farad.
 *
 * Common in ceramic and film capacitors used for filtering and decoupling.
 * Factor: 10^-9. 1 nF = 0.000000001 F.
 *
 * @see Capacitance::nanofarads()
 */
final readonly class Nanofarads extends CapacitanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::NANO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'nF';
    }
}
