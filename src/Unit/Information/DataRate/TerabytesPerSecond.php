<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\DataRate;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Information\DataRateUnit;
use Override;

/**
 * Data rate unit representing 10^12 bytes transferred per second.
 *
 * Symbol: TB/s. Conversion factor: 10^12 (1 TB/s = 1,000,000,000,000 B/s).
 * Used for aggregate data center bandwidth and high-performance computing interconnects.
 *
 * @see TerabytesPerSecond::make()
 */
final readonly class TerabytesPerSecond extends DataRateUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::TERA->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'TB/s';
    }
}
