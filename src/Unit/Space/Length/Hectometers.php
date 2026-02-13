<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Length;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Override;

/**
 * Hectometer (hm) -- a unit of length equal to 100 meters.
 *
 * Primarily used in meteorology and some European contexts for short distances.
 * One hectometer is one tenth of a kilometer.
 *
 * @see Length::hectometers() to create a Length quantity in hectometers.
 */
final readonly class Hectometers extends LengthUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::HECTO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'hm';
    }
}
