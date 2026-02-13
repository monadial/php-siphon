<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Motion\Acceleration;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Motion\AccelerationUnit;
use Override;

/**
 * Imperial/US customary unit of acceleration.
 *
 * Symbol: ft/s2. Conversion factor: 0.3048 (1 ft/s^2 = 0.3048 m/s^2).
 * Used in engineering contexts within the United States.
 *
 * @see FeetPerSecondSquared::make()
 */
final readonly class FeetPerSecondSquared extends AccelerationUnit
{
    private const float FACTOR = 0.3048;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'ft/s2';
    }
}
