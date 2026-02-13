<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\DataRate;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Information\DataRateUnit;
use Override;

/**
 * Data rate unit representing 1,000 bits transferred per second.
 *
 * Symbol: kb/s. Conversion factor: 125 (1 kb/s = 125 B/s).
 * Common in DSL and low-bandwidth network speed measurements.
 *
 * @see KilobitsPerSecond::make()
 */
final readonly class KilobitsPerSecond extends DataRateUnit
{
    private const int FACTOR = 125;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'kb/s';
    }
}
