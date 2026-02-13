<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Force;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\ForceUnit;
use Override;

/**
 * Dyne (dyn) -- the CGS unit of force.
 *
 * Symbol: dyn. Conversion factor: 10^-5 (1 dyn = 0.00001 N).
 * One dyne is the force required to accelerate a one-gram mass at one centimeter
 * per second squared. Still used in some surface tension and viscosity measurements.
 *
 * @see Force::dynes() for the factory method
 */
final readonly class Dynes extends ForceUnit
{
    private const float FACTOR = 1e-5;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'dyn';
    }
}
