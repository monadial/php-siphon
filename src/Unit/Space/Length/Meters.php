<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Length;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Override;

/**
 * Meter (m) -- the SI base unit of length.
 *
 * Defined since 2019 as the distance light travels in vacuum in 1/299,792,458 of a second.
 * This is the reference unit (factor = 1) for all length conversions.
 *
 * @see Length::meters() to create a Length quantity in meters.
 */
final readonly class Meters extends LengthUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'm';
    }
}
