<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Energy;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Override;

/**
 * Gigajoule (GJ) -- one billion joules.
 *
 * Symbol: GJ. Conversion factor: 10^9 (1 GJ = 1,000,000,000 J).
 * Used for large-scale energy accounting such as natural gas billing and
 * industrial process energy consumption.
 *
 * @see Energy::gigajoules() for the factory method
 */
final readonly class Gigajoules extends EnergyUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::GIGA->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'GJ';
    }
}
