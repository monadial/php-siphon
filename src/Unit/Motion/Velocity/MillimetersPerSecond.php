<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Motion\Velocity;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Motion\VelocityUnit;
use Override;

/**
 * One thousandth of a meter per second.
 *
 * Symbol: mm/s. Conversion factor: 10^-3 (1 mm/s = 0.001 m/s).
 * Used in precision engineering and slow-motion measurements.
 *
 * @see MillimetersPerSecond::make()
 */
final readonly class MillimetersPerSecond extends VelocityUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'mm/s';
    }
}
