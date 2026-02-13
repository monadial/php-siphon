<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Force;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\ForceUnit;
use Override;

/**
 * Kilogram-force (kgf) -- the gravitational force on one kilogram at standard gravity.
 *
 * Symbol: kgf. Conversion factor: 9.80665 (1 kgf = 9.80665 N exactly).
 * Defined as the force exerted by one kilogram of mass under standard gravity
 * (9.80665 m/s^2). Historically used in engineering before the adoption of SI newtons.
 *
 * @see Force::kilogramForce() for the factory method
 */
final readonly class KilogramForce extends ForceUnit
{
    private const float FACTOR = 9.80665;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'kgf';
    }
}
