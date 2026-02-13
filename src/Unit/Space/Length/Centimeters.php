<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Length;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Override;

/**
 * Centimeter (cm) -- a unit of length equal to 10^-2 meters.
 *
 * Common in everyday measurements, clothing sizes, and body dimensions.
 * One inch equals exactly 2.54 centimeters.
 *
 * @see Length::centimeters() to create a Length quantity in centimeters.
 */
final readonly class Centimeters extends LengthUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::CENTI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'cm';
    }
}
