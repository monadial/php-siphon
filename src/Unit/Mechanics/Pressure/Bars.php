<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\Pressure;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\PressureUnit;
use Override;

/**
 * Bar (bar) -- a metric unit of pressure equal to 100,000 pascals.
 *
 * Symbol: bar. Conversion factor: 100,000 (1 bar = 10^5 Pa).
 * Approximately equal to atmospheric pressure at sea level. Widely used in
 * meteorology, scuba diving, and industrial pressure gauges.
 *
 * @see Pressure::bars() for the factory method
 */
final readonly class Bars extends PressureUnit
{
    private const int FACTOR = 100_000;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'bar';
    }
}
