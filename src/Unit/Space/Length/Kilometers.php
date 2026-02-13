<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Length;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Space\LengthUnit;
use Override;

/**
 * Kilometer (km) -- a unit of length equal to 10^3 meters.
 *
 * The standard unit for road distances and geographic scales in most of the world.
 * A marathon is 42.195 km.
 *
 * @see Length::kilometers() to create a Length quantity in kilometers.
 */
final readonly class Kilometers extends LengthUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::KILO->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'km';
    }
}
