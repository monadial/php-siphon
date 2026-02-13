<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Motion\Acceleration;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Motion\AccelerationUnit;
use Override;

/**
 * The SI derived unit of acceleration.
 *
 * Symbol: m/s2. Conversion factor: 1 (base unit).
 * Represents the change in velocity of one meter per second every second.
 *
 * @see MetersPerSecondSquared::make()
 */
final readonly class MetersPerSecondSquared extends AccelerationUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'm/s2';
    }
}
