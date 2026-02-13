<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricalConductance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricalConductanceUnit;
use Override;

/**
 * The microsiemens (uS) — one millionth of a siemens.
 *
 * Commonly used for measuring the conductivity of pure or deionised water.
 * Factor: 10^-6. 1 uS = 0.000001 S.
 *
 * @see ElectricalConductance::microsiemens()
 */
final readonly class Microsiemens extends ElectricalConductanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MICRO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'uS';
    }
}
