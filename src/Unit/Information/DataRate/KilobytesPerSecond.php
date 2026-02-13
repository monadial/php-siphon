<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\DataRate;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Information\DataRateUnit;
use Override;

/**
 * Data rate unit representing 1,000 bytes transferred per second.
 *
 * Symbol: kB/s. Conversion factor: 10^3 (1 kB/s = 1,000 B/s).
 * Used for file download speed displays and application-level throughput.
 *
 * @see KilobytesPerSecond::make()
 */
final readonly class KilobytesPerSecond extends DataRateUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'kB/s';
    }
}
