<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\Inductance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\InductanceUnit;
use Override;

/**
 * The nanohenry (nH) — one billionth of a henry.
 *
 * Used in high-frequency RF circuits, PCB trace inductance, and
 * chip-scale inductors.
 * Factor: 10^-9. 1 nH = 0.000000001 H.
 *
 * @see Inductance::nanohenrys()
 */
final readonly class Nanohenrys extends InductanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::NANO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'nH';
    }
}
