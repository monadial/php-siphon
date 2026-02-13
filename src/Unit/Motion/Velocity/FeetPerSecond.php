<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Motion\Velocity;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Motion\VelocityUnit;
use Override;

/**
 * Imperial/US customary unit of velocity.
 *
 * Symbol: ft/s. Conversion factor: 0.3048 (1 ft/s = 0.3048 m/s exactly).
 * Used in ballistics and US engineering for projectile and fluid velocities.
 *
 * @see FeetPerSecond::make()
 */
final readonly class FeetPerSecond extends VelocityUnit
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
        return 'ft/s';
    }
}
