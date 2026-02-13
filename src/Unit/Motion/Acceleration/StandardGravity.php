<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Motion\Acceleration;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Motion\AccelerationUnit;
use Override;

/**
 * Standard gravitational acceleration at Earth's surface.
 *
 * Symbol: g0. Conversion factor: 9.80665 (1 g = 9.80665 m/s^2 exactly).
 * Defined by the 3rd CGPM (1901) as the standard acceleration due to gravity.
 * Used in aerospace, automotive, and physics for expressing g-forces.
 *
 * @see StandardGravity::make()
 */
final readonly class StandardGravity extends AccelerationUnit
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
        return 'g0';
    }
}
