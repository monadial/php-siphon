<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\DataRate;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Information\DataRateUnit;
use Override;

/**
 * Data rate unit representing 10^9 bytes transferred per second.
 *
 * Symbol: GB/s. Conversion factor: 10^9 (1 GB/s = 1,000,000,000 B/s).
 * Used for NVMe SSD throughput and high-performance memory bandwidth.
 *
 * @see GigabytesPerSecond::make()
 */
final readonly class GigabytesPerSecond extends DataRateUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::GIGA->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'GB/s';
    }
}
