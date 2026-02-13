<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Energy;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\EnergyUnit;
use Override;

/**
 * Kilojoule (kJ) -- one thousand joules.
 *
 * Symbol: kJ. Conversion factor: 10^3 (1 kJ = 1000 J).
 * Commonly used for expressing food energy content in many countries and for
 * measuring energy in chemical reactions and heating processes.
 *
 * @see Energy::kilojoules() for the factory method
 */
final readonly class Kilojoules extends EnergyUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'kJ';
    }
}
