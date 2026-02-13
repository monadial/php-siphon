<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Motion\Velocity;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Motion\VelocityUnit;
use Override;

/**
 * Velocity in miles per hour, an imperial/US customary unit.
 *
 * Symbol: mph. Conversion factor: 0.44704 (1 mph = 0.44704 m/s exactly).
 * Used for road vehicle speed in the United States, United Kingdom, and others.
 *
 * @see MilesPerHour::make()
 */
final readonly class MilesPerHour extends VelocityUnit
{
    private const float FACTOR = 0.44704;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'mph';
    }
}
