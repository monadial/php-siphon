<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\DataRate;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Information\DataRateUnit;
use Override;

/**
 * Data rate unit representing 10^6 bytes transferred per second.
 *
 * Symbol: MB/s. Conversion factor: 10^6 (1 MB/s = 1,000,000 B/s).
 * Common for SSD read/write speeds and USB transfer rate specifications.
 *
 * @see MegabytesPerSecond::make()
 */
final readonly class MegabytesPerSecond extends DataRateUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MEGA->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'MB/s';
    }
}
