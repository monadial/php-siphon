<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\Capacitance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\CapacitanceUnit;
use Override;

/**
 * The microfarad (uF) — one millionth of a farad.
 *
 * Commonly used for electrolytic and ceramic capacitors in electronics.
 * Factor: 10^-6. 1 uF = 0.000001 F.
 *
 * @see Capacitance::microfarads()
 */
final readonly class Microfarads extends CapacitanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MICRO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'uF';
    }
}
