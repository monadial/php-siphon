<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricCharge;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricChargeUnit;
use Override;

/**
 * The coulomb (C) — SI base unit of electric charge.
 *
 * One coulomb is the charge transported by one ampere of current in one second.
 * Factor: 1 (base unit). 1 C = 1 A*s.
 *
 * @see ElectricCharge::coulombs()
 */
final readonly class Coulombs extends ElectricChargeUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'C';
    }
}
