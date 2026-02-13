<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\DataRate;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Information\DataRateUnit;
use Override;

/**
 * Data rate unit representing one bit transferred per second.
 *
 * Symbol: b/s. Conversion factor: 0.125 (1 b/s = 1/8 B/s).
 * The fundamental unit of data transfer speed in telecommunications.
 *
 * @see BitsPerSecond::make()
 */
final readonly class BitsPerSecond extends DataRateUnit
{
    private const float FACTOR = 0.125;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'b/s';
    }
}
