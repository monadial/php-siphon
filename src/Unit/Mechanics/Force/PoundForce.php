<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Force;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\ForceUnit;
use Override;

/**
 * Pound-force (lbf) -- the imperial/US customary unit of force.
 *
 * Symbol: lbf. Conversion factor: 4.4482216152605 (1 lbf = 4.448222 N approximately).
 * Defined as the gravitational force on one avoirdupois pound at standard gravity.
 * Widely used in US engineering, aerospace, and automotive industries.
 *
 * @see Force::poundForce() for the factory method
 */
final readonly class PoundForce extends ForceUnit
{
    private const float FACTOR = 4.4482216152605;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'lbf';
    }
}
