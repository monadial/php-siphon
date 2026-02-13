<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\Inductance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\InductanceUnit;
use Override;

/**
 * The microhenry (uH) — one millionth of a henry.
 *
 * Used in RF inductors, chokes, and switching regulator designs.
 * Factor: 10^-6. 1 uH = 0.000001 H.
 *
 * @see Inductance::microhenrys()
 */
final readonly class Microhenrys extends InductanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MICRO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'uH';
    }
}
