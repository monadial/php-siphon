<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * Cubic meter (m^3) -- the SI derived unit of volume.
 *
 * This is the reference unit (factor = 1) for all volume conversions. One cubic
 * meter equals 1000 litres. Used in engineering, construction, and shipping.
 *
 * @see Volume::cubicMeters() to create a Volume quantity in cubic meters.
 */
final readonly class CubicMeters extends VolumeUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }

    #[Override]
    public function symbol(): string
    {
        return 'm3';
    }
}
