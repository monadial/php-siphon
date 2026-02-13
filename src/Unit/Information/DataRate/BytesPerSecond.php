<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\DataRate;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Information\DataRateUnit;
use Override;

/**
 * The base data rate unit representing one byte transferred per second.
 *
 * Symbol: B/s. Conversion factor: 1 (base unit).
 * All other data rate units convert through bytes per second.
 *
 * @see BytesPerSecond::make()
 */
final readonly class BytesPerSecond extends DataRateUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'B/s';
    }
}
