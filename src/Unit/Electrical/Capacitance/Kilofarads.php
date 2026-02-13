<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\Capacitance;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\CapacitanceUnit;
use Override;

/**
 * The kilofarad (kF) — one thousand farads.
 *
 * Used for extremely large capacitances such as supercapacitor banks.
 * Factor: 10^3. 1 kF = 1000 F.
 *
 * @see Capacitance::kilofarads()
 */
final readonly class Kilofarads extends CapacitanceUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'kF';
    }
}
