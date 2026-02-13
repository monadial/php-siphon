<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\VolumeFlow;

use Brick\Math\BigDecimal;
use Monadial\Siphon\Unit\Mechanics\VolumeFlowUnit;
use Override;

/**
 * US gallons per minute (GPM) -- an imperial volume flow rate unit.
 *
 * Symbol: gal/min. Conversion factor: 6.30902e-5 (1 GPM = 6.309e-5 m^3/s approximately).
 * The standard unit for pump ratings and plumbing specifications in the US.
 * A typical residential water well pump delivers 5-25 GPM.
 *
 * @see VolumeFlow::gallonsPerMinute() for the factory method
 */
final readonly class GallonsPerMinute extends VolumeFlowUnit
{
    private const float FACTOR = 6.30901964e-5;

    #[Override]
    public function factor(): BigDecimal
    {
        return BigDecimal::of(self::FACTOR);
    }

    #[Override]
    public function symbol(): string
    {
        return 'gal/min';
    }
}
