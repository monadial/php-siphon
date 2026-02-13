<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Information\DataRate;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Information\DataRateUnit;
use Override;

/**
 * Data rate unit representing 10^6 bits transferred per second.
 *
 * Symbol: Mb/s. Conversion factor: 125,000 (1 Mb/s = 125,000 B/s).
 * The standard unit for consumer broadband and Ethernet speed ratings.
 *
 * @see MegabitsPerSecond::make()
 */
final readonly class MegabitsPerSecond extends DataRateUnit
{
    private const int FACTOR = 125_000;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'Mb/s';
    }
}
