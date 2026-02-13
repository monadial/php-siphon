<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Length;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Override;

/**
 * Millimeter (mm) -- a unit of length equal to 10^-3 meters.
 *
 * Widely used in engineering, manufacturing, and everyday measurements.
 * Standard paper thickness is approximately 0.1 mm.
 *
 * @see Length::millimeters() to create a Length quantity in millimeters.
 */
final readonly class Millimeters extends LengthUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::MILLI->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'mm';
    }
}
