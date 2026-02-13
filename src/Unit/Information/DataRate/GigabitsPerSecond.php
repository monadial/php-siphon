<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\DataRate;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Information\DataRateUnit;
use Override;

/**
 * Data rate unit representing 10^9 bits transferred per second.
 *
 * Symbol: Gb/s. Conversion factor: 125,000,000 (1 Gb/s = 125,000,000 B/s).
 * Used for high-speed networking such as fiber optics and data center interconnects.
 *
 * @see GigabitsPerSecond::make()
 */
final readonly class GigabitsPerSecond extends DataRateUnit
{
    private const int FACTOR = 125_000_000;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'Gb/s';
    }
}
