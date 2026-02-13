<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Momentum;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\MomentumUnit;
use Override;

/**
 * Kilogram meter per second (kg*m/s) -- the SI unit of momentum.
 *
 * Symbol: kg*m/s. Conversion factor: 1 (base unit).
 * The fundamental unit for expressing linear momentum. A 1 kg object moving
 * at 1 m/s has a momentum of 1 kg*m/s.
 *
 * @see Momentum::kilogramMetersPerSecond() for the factory method
 */
final readonly class KilogramMetersPerSecond extends MomentumUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'kg*m/s';
    }
}
