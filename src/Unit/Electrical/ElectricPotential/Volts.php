<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Electrical\ElectricPotential;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Electrical\ElectricPotentialUnit;
use Override;

/**
 * The volt (V) — SI derived unit of electric potential.
 *
 * One volt is the potential difference that drives one ampere of current
 * through one ohm of resistance.
 * Factor: 1 (base unit). 1 V = 1 kg*m^2/(A*s^3).
 *
 * @see ElectricPotential::volts()
 */
final readonly class Volts extends ElectricPotentialUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'V';
    }
}
