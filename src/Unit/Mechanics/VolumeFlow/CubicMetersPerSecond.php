<?php

declare(strict_types=1);

namespace Monadial\Siphon\Unit\Mechanics\VolumeFlow;

use Brick\Math\BigDecimal;
use Monadial\Siphon\System\MetricSystem;
use Monadial\Siphon\Unit\Mechanics\VolumeFlowUnit;
use Override;

/**
 * @psalm-api
 */
final readonly class CubicMetersPerSecond extends VolumeFlowUnit
{
    #[Override]
    public function factor(): BigDecimal
    {
        return MetricSystem::BASE->factor();
    }
}
