<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Space\Volume;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Space\VolumeUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class CubicMeters extends VolumeUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }
}
