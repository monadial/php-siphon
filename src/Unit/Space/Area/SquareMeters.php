<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Area;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Space\AreaUnit;
use Override;

/**
 * Square meter (m^2) -- the SI derived unit of area.
 *
 * This is the reference unit (factor = 1) for all area conversions. Commonly used
 * in construction, real estate, and scientific measurements. A typical parking
 * space is about 12 m^2.
 *
 * @see Area::squareMeters() to create an Area quantity in square meters.
 */
final readonly class SquareMeters extends AreaUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'm2';
    }
}
