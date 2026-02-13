<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Motion\Velocity;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Motion\VelocityUnit;
use Override;

/**
 * One thousand meters per second.
 *
 * Symbol: km/s. Conversion factor: 10^3 (1 km/s = 1,000 m/s).
 * Used in astronomy and astrophysics for orbital and escape velocities.
 *
 * @see KilometersPerSecond::make()
 */
final readonly class KilometersPerSecond extends VelocityUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'km/s';
    }
}
